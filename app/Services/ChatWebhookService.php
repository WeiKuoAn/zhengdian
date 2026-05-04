<?php

namespace App\Services;

use App\Models\ChatWebhookEvent;
use App\Models\CustData;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChatWebhookService
{
    public function verifyRequest(Request $request): array
    {
        if (!$this->verifyIp($request)) {
            Log::warning('chat_webhook_verify_failed', [
                'reason' => 'IP not allowed',
                'ip' => $request->ip(),
                'path' => $request->path(),
            ]);
            return ['verified' => false, 'reason' => 'IP not allowed'];
        }

        $tokenCheck = $this->verifyTokenDetailed($request);
        if (!$tokenCheck['verified']) {
            Log::warning('chat_webhook_verify_failed', [
                'reason' => 'Invalid webhook token',
                'path' => $request->path(),
                'provided' => $tokenCheck['provided_masked'],
                'expected' => $tokenCheck['expected_masked'],
                'payload' => $this->maskSensitivePayload($this->extractPayload($request)),
            ]);
            return ['verified' => false, 'reason' => 'Invalid webhook token'];
        }

        if (!$this->verifySignature($request)) {
            Log::warning('chat_webhook_verify_failed', [
                'reason' => 'Invalid webhook signature',
                'path' => $request->path(),
            ]);
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
        $replyText = $echoText === '測試' ? '測試給我' : ($echoText !== '' ? "收到訊息：{$echoText}" : '收到訊息');

        return $this->markProcessed($event, 'processed', null, [
            'success' => true,
            'message' => $replyText,
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

    public function sendIncomingToSynology(string $text, array $userIds = []): array
    {
        $host = rtrim((string) config('chat_webhook.synology_host', ''), '/');
        $token = trim((string) config('chat_webhook.synology_bot_token', ''), "\"' ");

        if ($host === '' || $token === '') {
            return [
                'success' => false,
                'message' => 'Synology Chat host 或 bot token 未設定',
            ];
        }

        if (trim($text) === '') {
            return [
                'success' => false,
                'message' => '請輸入要發送到 Synology Chat 的文字',
            ];
        }

        $payload = ['text' => $text];

        $channelId = trim((string) config('chat_webhook.synology_dispatch_channel_id', ''));
        if ($channelId !== '') {
            // Synology Chat chatbot 發「頻道訊息」需帶 channel_id（否則 API 無目標、訊息不會出現）
            $payload['channel_id'] = $channelId;
        }

        if (!empty($userIds)) {
            $payload['user_ids'] = array_values(array_map('intval', $userIds));
        }

        if ($channelId === '' && empty($payload['user_ids'] ?? [])) {
            Log::error('synology_chat_send_failed', [
                'reason' => 'chatbot 需 channel_id（頻道）或 user_ids（私訊）：私訊請為每位執行人填 synology_user_id；發頻道才需 SYNOLOGY_CHAT_DISPATCH_CHANNEL_ID',
            ]);

            return [
                'success' => false,
                'message' => 'Synology Chat chatbot 未設定發送目標：私訊請為執行人填寫 synology_user_id；若要發頻道再設定 SYNOLOGY_CHAT_DISPATCH_CHANNEL_ID',
            ];
        }

        $url = $host . '/webapi/entry.cgi?' . http_build_query([
            'api' => 'SYNO.Chat.External',
            'method' => 'chatbot',
            'version' => '2',
            'token' => $token,
        ]);

        Log::info('synology_chat_send', [
            'channel_id' => $channelId !== '' ? $channelId : null,
            'user_ids' => $userIds,
            'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);

        $response = Http::asForm()->post($url, [
            'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);

        $body = $response->json();
        if ($body === null && $response->body() !== '') {
            Log::warning('synology_chat_send_non_json', [
                'http_status' => $response->status(),
                'body_preview' => Str::limit($response->body(), 500),
            ]);
        }
        if ($response->successful() && is_array($body) && ($body['success'] ?? false) === true) {
            return [
                'success' => true,
                'message' => '已送出到 Synology Chat',
                'data' => $body,
            ];
        }

        $synoCode = is_array($body) ? (int) data_get($body, 'error.code', 0) : 0;
        if ($synoCode === 800) {
            Log::error('synology_chat_send_failed', [
                'http_status' => $response->status(),
                'response' => $body,
                'hint' => 'code 800 = no target：POST 的 payload 須含 channel_id（頻道）或 user_ids（私訊）。私訊請確認 user_ids 已帶入且為 Synology Chat 使用者 ID；勿只用瀏覽器 GET 測試。',
            ]);
        } else {
            Log::error('synology_chat_send_failed', [
                'http_status' => $response->status(),
                'response' => $body,
            ]);
        }

        $failMessage = 'Synology Chat 回傳失敗';
        if ($synoCode === 800) {
            $failMessage .= '（無發送目標：私訊請確認執行人 synology_user_id；發頻道請設定 SYNOLOGY_CHAT_DISPATCH_CHANNEL_ID）';
        }

        return [
            'success' => false,
            'message' => $failMessage,
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
                'message' => "可用指令：/search 姓名、/help {統編}、/task done {id}、/task show {id}",
                'data' => ['commands' => ['/search 姓名', '/help {統編}', '/task done {id}', '/task show {id}']],
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

        if (preg_match('/^\/?search\s*(.*)$/u', trim($commandText), $matches)) {
            $name = trim((string) ($matches[1] ?? ''));

            return $this->searchTasksForUserName($name);
        }

        return [
            'success' => false,
            'message' => 'Unsupported command format. Try /help',
            'http_status' => 422,
        ];
    }

    /**
     * /search 姓名：列出該使用者「未完成」派工（排除 task.status=已完成），依專案分組排版。
     */
    protected function searchTasksForUserName(string $name): array
    {
        if ($name === '') {
            return [
                'success' => true,
                'message' => '請輸入：/search 使用者姓名',
                'http_status' => 200,
            ];
        }

        $user = User::query()->where('name', $name)->first();
        if ($user === null) {
            return [
                'success' => true,
                'message' => '找不到姓名為「' . $name . '」的使用者。',
                'http_status' => 200,
            ];
        }

        $items = TaskItem::query()
            ->where('user_id', $user->id)
            ->whereHas('task_data', function ($q) {
                $q->whereNotIn('status', ['9', 9]);
            })
            ->with([
                'task_data.project_data.user_data',
                'task_data.task_template_data',
            ])
            ->orderBy('task_id')
            ->get();

        if ($items->isEmpty()) {
            return [
                'success' => true,
                'message' => $this->searchDispatchQueryPreamble($name) . '目前無未完成的派工',
                'http_status' => 200,
            ];
        }

        $byProject = $items->groupBy(function ($item) {
            return (int) (optional($item->task_data)->project_id ?? 0);
        });

        $blocks = [];
        foreach ($byProject->sortKeys() as $projectItems) {
            $first = $projectItems->first();
            $task0 = $first?->task_data;
            $proj = $task0?->project_data;
            $prefix = (string) (optional($proj?->user_data)->name ?? '');
            $projectLabel = $prefix . ($proj?->name ?? '未命名專案');

            $lines = [];
            $lines[] = '【' . $projectLabel . '】';

            foreach ($projectItems->unique('task_id') as $item) {
                $task = $item->task_data;
                if ($task === null) {
                    continue;
                }
                $taskLabel = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');
                $statusText = $task->status();
                $scheduledRaw = $task->getAttribute('estimated_end');
                $scheduledText = '';
                if ($scheduledRaw !== null && $scheduledRaw !== '') {
                    try {
                        $scheduledText = Carbon::parse($scheduledRaw)->format('Y-m-d');
                    } catch (\Throwable $e) {
                        $scheduledText = (string) $scheduledRaw;
                    }
                } else {
                    $scheduledText = '—';
                }
                $lines[] = '　-' . $taskLabel . '（' . $statusText . '） / 表定時間：' . $scheduledText;
            }

            $blocks[] = implode("\n", $lines);
        }

        return [
            'success' => true,
            'message' => $this->searchDispatchQueryPreamble($name) . implode("\n\n", $blocks),
            'http_status' => 200,
        ];
    }

    /** /search 回覆前綴：派工列表連結 + 查詢對象說明 */
    protected function searchDispatchQueryPreamble(string $name): string
    {
        return "派工列表：https://zhengdian.com.tw/task\n\n以下是【{$name}】的派工查詢：\n\n";
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
        return $this->verifyTokenDetailed($request)['verified'];
    }

    protected function resolveExpectedTokensByRequest(Request $request): array
    {
        $tokens = [];

        $baseToken = trim((string) config('chat_webhook.verify_token', ''), "\"' ");
        if ($baseToken !== '') {
            $tokens[] = $baseToken;
        }

        // 相容既有 Synology token 設定（透過 config 載入，避免 config:cache 失效）
        $legacyCommon = trim((string) config('chat_webhook.synology_token', ''), "\"' ");
        if ($legacyCommon !== '') {
            $tokens[] = $legacyCommon;
        }

        $path = (string) $request->path();
        if (str_ends_with($path, '/outgoing')) {
            $legacyOutgoing = trim((string) config('chat_webhook.synology_outgoing_token', ''), "\"' ");
            if ($legacyOutgoing !== '') {
                $tokens[] = $legacyOutgoing;
            }
            // 相容錯置：有些環境會把 slash token 填到 outgoing
            $legacySlash = trim((string) config('chat_webhook.synology_slash_token', ''), "\"' ");
            if ($legacySlash !== '') {
                $tokens[] = $legacySlash;
            }
        }

        if (str_ends_with($path, '/slash')) {
            $legacySlash = trim((string) config('chat_webhook.synology_slash_token', ''), "\"' ");
            if ($legacySlash !== '') {
                $tokens[] = $legacySlash;
            }
            $searchSlash = trim((string) config('chat_webhook.synology_search_slash_token', ''), "\"' ");
            if ($searchSlash !== '') {
                $tokens[] = $searchSlash;
            }
            // 相容錯置：有些環境會把 outgoing token 填到 slash
            $legacyOutgoing = trim((string) config('chat_webhook.synology_outgoing_token', ''), "\"' ");
            if ($legacyOutgoing !== '') {
                $tokens[] = $legacyOutgoing;
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

    protected function verifyTokenDetailed(Request $request): array
    {
        $expectedTokens = $this->resolveExpectedTokensByRequest($request);
        if (empty($expectedTokens)) {
            return [
                'verified' => true,
                'provided_masked' => [],
                'expected_masked' => [],
            ];
        }

        $payload = $this->extractPayload($request);
        $headerToken = trim((string) $request->header('X-Webhook-Token', ''), "\"' ");
        $bearerToken = trim((string) $request->bearerToken(), "\"' ");
        $payloadToken = trim((string) (($payload['_token'] ?? $payload['token'] ?? $request->query('token') ?? '')), "\"' ");

        $providedTokens = array_values(array_filter([$headerToken, $bearerToken, $payloadToken], static fn ($v) => $v !== ''));
        if (empty($providedTokens)) {
            return [
                'verified' => false,
                'provided_masked' => [],
                'expected_masked' => array_map(fn ($v) => $this->maskToken($v), $expectedTokens),
            ];
        }

        foreach ($expectedTokens as $expected) {
            foreach ($providedTokens as $provided) {
                if (hash_equals($expected, $provided)) {
                    return [
                        'verified' => true,
                        'provided_masked' => array_map(fn ($v) => $this->maskToken($v), $providedTokens),
                        'expected_masked' => array_map(fn ($v) => $this->maskToken($v), $expectedTokens),
                    ];
                }
            }
        }

        return [
            'verified' => false,
            'provided_masked' => array_map(fn ($v) => $this->maskToken($v), $providedTokens),
            'expected_masked' => array_map(fn ($v) => $this->maskToken($v), $expectedTokens),
        ];
    }

    protected function maskToken(string $token): string
    {
        if ($token === '') {
            return '';
        }
        if (strlen($token) <= 8) {
            return str_repeat('*', strlen($token));
        }

        return substr($token, 0, 4) . str_repeat('*', max(strlen($token) - 8, 0)) . substr($token, -4);
    }

    protected function maskSensitivePayload(array $payload): array
    {
        foreach (['_token', 'token', 'authorization'] as $key) {
            if (isset($payload[$key]) && is_string($payload[$key])) {
                $payload[$key] = $this->maskToken($payload[$key]);
            }
        }

        return $payload;
    }
}
