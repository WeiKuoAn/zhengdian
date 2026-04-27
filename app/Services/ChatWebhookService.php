<?php

namespace App\Services;

use App\Models\ChatWebhookEvent;
use App\Models\CustData;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
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
        $payload = $this->extractPayload($request);
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
        $payload = $this->extractPayload($request);
        $echoText = trim((string) ($payload['text'] ?? $payload['message'] ?? ''));

        return $this->markProcessed($event, 'processed', null, [
            'success' => true,
            'message' => $echoText !== '' ? "收到訊息：{$echoText}" : '收到訊息',
            'data' => [
                'echo_text' => $echoText,
            ],
        ]);
    }

    public function handleInbound(ChatWebhookEvent $event, Request $request): array
    {
        $payload = $this->extractPayload($request);
        return $this->markProcessed($event, 'processed', null, [
            'received' => true,
            'channel_id' => $payload['channel_id'] ?? $request->input('channel_id'),
        ]);
    }

    public function sendIncomingToSynology(string $text): array
    {
        $host = rtrim((string) env('SYNOLOGY_CHAT_HOST', ''), '/');
        $token = trim((string) env('SYNOLOGY_CHAT_TOKEN', ''), "\"' ");

        if ($host === '' || $token === '') {
            return [
                'success' => false,
                'message' => 'SYNOLOGY_CHAT_HOST 或 SYNOLOGY_CHAT_TOKEN 未設定',
            ];
        }

        if (trim($text) === '') {
            return [
                'success' => false,
                'message' => '請輸入要發送到 Synology Chat 的文字',
            ];
        }

        $url = $host . '/webapi/entry.cgi';
        $response = Http::asForm()->post($url, [
            'api' => 'SYNO.Chat.External',
            'method' => 'incoming',
            'version' => '2',
            'token' => $token,
            'payload' => json_encode([
                'text' => $text,
            ], JSON_UNESCAPED_UNICODE),
        ]);

        $body = $response->json();
        if ($response->successful() && is_array($body) && ($body['success'] ?? false) === true) {
            return [
                'success' => true,
                'message' => '已送出到 Synology Chat',
                'data' => $body,
            ];
        }

        return [
            'success' => false,
            'message' => 'Synology Chat 回傳失敗',
            'data' => $body,
        ];
    }

    public function handleSlash(ChatWebhookEvent $event, Request $request): array
    {
        $payload = $this->extractPayload($request);
        $rawText = trim((string) ($payload['text'] ?? $payload['message'] ?? ''));
        $commandRaw = trim((string) ($payload['command'] ?? ''));

        // Synology slash 常見格式：command 與 text 分開送，這裡合併成完整命令
        $commandText = $commandRaw !== ''
            ? trim($commandRaw . ' ' . $rawText)
            : $rawText;

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

        if (preg_match('/^\/?help(?:\s+(.+))?$/i', trim($commandText), $matches)) {
            $registrationNo = trim((string) ($matches[1] ?? ''));
            if ($registrationNo !== '') {
                return $this->findCompanyIntroByRegistrationNo($registrationNo);
            }

            return [
                'success' => true,
                'message' => "可用指令：/help {統編}、/task done {id}、/task show {id}",
                'data' => ['commands' => ['/help {統編}', '/task done {id}', '/task show {id}']],
                'http_status' => 200,
            ];
        }

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

    protected function findCompanyIntroByRegistrationNo(string $registrationNo): array
    {
        $company = CustData::query()
            ->where('registration_no', $registrationNo)
            ->first(['registration_no', 'introduce']);

        if (!$company) {
            return [
                'success' => false,
                'message' => "查無統編 {$registrationNo} 的客戶資料",
                'http_status' => 422,
            ];
        }

        $intro = trim((string) ($company->introduce ?? ''));
        if ($intro === '') {
            return [
                'success' => true,
                'message' => "統編 {$registrationNo} 已建檔，但尚未填寫公司簡介",
                'http_status' => 200,
            ];
        }

        return [
            'success' => true,
            'message' => "統編 {$registrationNo} 公司簡介：{$intro}",
            'data' => [
                'registration_no' => $registrationNo,
                'introduce' => $intro,
            ],
            'http_status' => 200,
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
        $expectedTokens = $this->resolveExpectedTokensByRequest($request);
        if (empty($expectedTokens)) {
            return true;
        }

        $payload = $this->extractPayload($request);
        $headerToken = trim((string) $request->header('X-Webhook-Token', ''));
        $bearerToken = trim((string) $request->bearerToken());
        $payloadToken = trim((string) (($payload['_token'] ?? $payload['token'] ?? '')));

        $providedTokens = array_values(array_filter([$headerToken, $bearerToken, $payloadToken], static fn ($v) => $v !== ''));
        if (empty($providedTokens)) {
            return false;
        }

        foreach ($expectedTokens as $expected) {
            foreach ($providedTokens as $provided) {
                if (hash_equals($expected, $provided)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function resolveExpectedTokensByRequest(Request $request): array
    {
        $tokens = [];

        $baseToken = trim((string) config('chat_webhook.verify_token', ''));
        if ($baseToken !== '') {
            $tokens[] = $baseToken;
        }

        // 相容既有 .env 變數（SYNOLOGY_CHAT_*）
        $legacyCommon = trim((string) env('SYNOLOGY_CHAT_TOKEN', ''));
        if ($legacyCommon !== '') {
            $tokens[] = $legacyCommon;
        }

        $path = (string) $request->path();
        if (str_ends_with($path, '/outgoing')) {
            $legacyOutgoing = trim((string) env('SYNOLOGY_CHAT_OUTGOING_TOKEN', ''));
            if ($legacyOutgoing !== '') {
                $tokens[] = $legacyOutgoing;
            }
        }

        if (str_ends_with($path, '/slash')) {
            $legacySlash = trim((string) env('SYNOLOGY_CHAT_SLASH_TOKEN', ''));
            if ($legacySlash !== '') {
                $tokens[] = $legacySlash;
            }
        }

        return array_values(array_unique(array_filter($tokens, static fn ($v) => $v !== '')));
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

    /**
     * Synology 可能送 x-www-form-urlencoded payload={"text":"..."}，這裡統一展開。
     */
    protected function extractPayload(Request $request): array
    {
        $payload = $request->all();

        if (isset($payload['payload']) && is_string($payload['payload'])) {
            $decoded = json_decode($payload['payload'], true);
            if (is_array($decoded)) {
                unset($payload['payload']);
                $payload = array_merge($payload, $decoded);
            }
        }

        return $payload;
    }
}
