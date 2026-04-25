<?php

namespace App\Services;

use App\Models\ChatWebhookEvent;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChatWebhookService
{
    public function verifyRequest(Request $request): array
    {
        if (!$this->verifyIp($request)) {
            return ['verified' => false, 'reason' => 'IP not allowed'];
        }

        if (!$this->verifyToken($request)) {
            return ['verified' => false, 'reason' => 'Invalid webhook token'];
        }

        if (!$this->verifySignature($request)) {
            return ['verified' => false, 'reason' => 'Invalid webhook signature'];
        }

        return ['verified' => true, 'reason' => null];
    }

    public function logEvent(Request $request, string $eventType, array $verifyResult): ChatWebhookEvent
    {
        $payload = $request->all();
        $text = (string) ($payload['text'] ?? $payload['message'] ?? '');
        $command = (string) ($payload['command'] ?? $this->extractCommand($text));

        return ChatWebhookEvent::create([
            'provider' => (string) config('chat_webhook.provider', 'synology_chat'),
            'event_type' => $eventType,
            'request_id' => (string) ($request->header('X-Request-Id') ?? Str::uuid()),
            'user_id_external' => (string) ($payload['user_id'] ?? $payload['user_id_external'] ?? ''),
            'username' => (string) ($payload['username'] ?? $payload['user_name'] ?? ''),
            'channel_id' => (string) ($payload['channel_id'] ?? ''),
            'command' => $command !== '' ? $command : null,
            'text' => $text !== '' ? $text : null,
            'payload_json' => (bool) config('chat_webhook.log_payload', true) ? $payload : ['message' => 'Payload logging disabled'],
            'headers_json' => $this->extractHeaders($request),
            'verified' => (bool) $verifyResult['verified'],
            'verify_reason' => $verifyResult['reason'],
        ]);
    }

    public function handleOutgoing(ChatWebhookEvent $event, Request $request): array
    {
        return $this->markProcessed($event, 'processed', null, [
            'echo_text' => (string) ($request->input('text') ?? $request->input('message') ?? ''),
        ]);
    }

    public function handleInbound(ChatWebhookEvent $event, Request $request): array
    {
        return $this->markProcessed($event, 'processed', null, [
            'received' => true,
            'channel_id' => $request->input('channel_id'),
        ]);
    }

    public function handleSlash(ChatWebhookEvent $event, Request $request): array
    {
        $rawText = trim((string) ($request->input('text') ?? $request->input('message') ?? ''));
        $commandText = trim((string) ($request->input('command') ?? $rawText));

        if ($commandText === '') {
            return $this->markProcessed($event, 'ignored', null, [
                'success' => false,
                'message' => 'Command is required',
                'http_status' => 422,
            ]);
        }

        $result = $this->routeSlashCommand($commandText);
        $status = $result['success'] ? 'processed' : (($result['http_status'] ?? 422) >= 500 ? 'failed' : 'ignored');

        return $this->markProcessed($event, $status, $result['success'] ? null : $result['message'], $result);
    }

    public function routeSlashCommand(string $commandText): array
    {
        $parts = preg_split('/\s+/', trim($commandText)) ?: [];
        $normalized = implode(' ', array_map(static fn ($part) => strtolower($part), $parts));

        if ($normalized === '/help' || $normalized === 'help') {
            return [
                'success' => true,
                'message' => "Available commands: /task done {id}, /task show {id}, /help",
                'data' => ['commands' => ['/task done {id}', '/task show {id}', '/help']],
                'http_status' => 200,
            ];
        }

        if (preg_match('/^\/?task\s+done\s+(\d+)$/i', $commandText, $matches)) {
            return $this->markTaskDone((int) $matches[1]);
        }

        if (preg_match('/^\/?task\s+show\s+(\d+)$/i', $commandText, $matches)) {
            return $this->showTask((int) $matches[1]);
        }

        return [
            'success' => false,
            'message' => 'Unsupported command format. Try /help',
            'http_status' => 422,
        ];
    }

    protected function markTaskDone(int $taskId): array
    {
        $task = Task::query()->find($taskId);
        if (!$task) {
            return [
                'success' => false,
                'message' => "Task {$taskId} not found",
                'http_status' => 422,
            ];
        }

        $update = ['status' => 9];
        if (Schema::hasColumn($task->getTable(), 'actual_end')) {
            $update['actual_end'] = Carbon::now();
        }

        $task->update($update);

        return [
            'success' => true,
            'message' => "Task {$taskId} marked as done",
            'data' => ['task_id' => $taskId, 'status' => 9],
            'http_status' => 200,
        ];
    }

    protected function showTask(int $taskId): array
    {
        $task = Task::query()->find($taskId);
        if (!$task) {
            return [
                'success' => false,
                'message' => "Task {$taskId} not found",
                'http_status' => 422,
            ];
        }

        return [
            'success' => true,
            'message' => "Task {$taskId} found",
            'data' => [
                'task_id' => $task->id,
                'name' => $task->name,
                'status' => $task->status,
                'estimated_end' => $task->estimated_end,
            ],
            'http_status' => 200,
        ];
    }

    protected function markProcessed(ChatWebhookEvent $event, string $status, ?string $errorMessage, array $result): array
    {
        $event->update([
            'status' => $status,
            'processed_at' => Carbon::now(),
            'error_message' => $errorMessage,
        ]);

        return $result;
    }

    protected function verifyIp(Request $request): bool
    {
        $allowedIps = (array) config('chat_webhook.allowed_ips', []);
        if (empty($allowedIps)) {
            return true;
        }

        $ip = (string) $request->ip();
        return in_array($ip, $allowedIps, true);
    }

    protected function verifyToken(Request $request): bool
    {
        $configToken = trim((string) config('chat_webhook.verify_token', ''));
        if ($configToken === '') {
            return true;
        }

        $headerToken = trim((string) $request->header('X-Webhook-Token', ''));
        $bearerToken = trim((string) $request->bearerToken());

        return hash_equals($configToken, $headerToken) || hash_equals($configToken, $bearerToken);
    }

    protected function verifySignature(Request $request): bool
    {
        if (!(bool) config('chat_webhook.enable_signature_check', false)) {
            return true;
        }

        $headerName = (string) config('chat_webhook.signature_header', 'X-Webhook-Signature');
        $secret = (string) config('chat_webhook.signature_secret', '');
        $signature = (string) $request->header($headerName, '');

        if ($secret === '' || $signature === '') {
            return false;
        }

        $calculated = hash_hmac('sha256', (string) $request->getContent(), $secret);
        return hash_equals($calculated, $signature);
    }

    protected function extractHeaders(Request $request): array
    {
        $headerMap = [
            'x-request-id' => 'X-Request-Id',
            'authorization' => 'Authorization',
            'x-webhook-token' => 'X-Webhook-Token',
            'user-agent' => 'User-Agent',
            'content-type' => 'Content-Type',
            'x-forwarded-for' => 'X-Forwarded-For',
        ];

        $headers = [];
        foreach ($headerMap as $key => $name) {
            $value = $request->header($name);
            if ($value !== null && $value !== '') {
                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    protected function extractCommand(string $text): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }

        return Str::startsWith($text, '/') ? Str::before($text, ' ') : '';
    }
}
