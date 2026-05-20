<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ChatWebhookEvent extends Model
{
    protected $fillable = [
        'provider',
        'event_type',
        'request_id',
        'user_id_external',
        'username',
        'channel_id',
        'command',
        'text',
        'payload_json',
        'headers_json',
        'verified',
        'verify_reason',
        'status',
        'processed_at',
        'error_message',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'payload_json' => 'array',
        'headers_json' => 'array',
        'processed_at' => 'datetime',
    ];

    public static function eventTypeLabel(?string $eventType): string
    {
        return match ((string) $eventType) {
            'outgoing' => '傳出',
            'slash' => '斜線指令',
            'inbound' => '傳入',
            'auto_accept' => '自動提醒－未接收',
            'auto_due' => '自動提醒－繳交',
            'auto_due_pre' => '自動提醒－繳交前',
            'auto_overdue' => '自動提醒－遲交',
            'auto_due_overdue' => '自動提醒－遲交',
            default => (string) ($eventType ?? '-'),
        };
    }

    public static function statusLabel(?string $status): string
    {
        return match ((string) $status) {
            'processed' => '已處理',
            'failed' => '失敗',
            'ignored' => '已忽略',
            default => (string) ($status ?? '-'),
        };
    }

    public static function statusBadgeClass(?string $status): string
    {
        return match ((string) $status) {
            'processed' => 'success',
            'failed' => 'danger',
            'ignored' => 'secondary',
            default => 'secondary',
        };
    }

    public static function verifiedLabel(bool $verified): string
    {
        return $verified ? '已驗證' : '未驗證';
    }

    /** @return array<string, string> */
    public static function filterEventTypeOptions(): array
    {
        return [
            '' => '全部類型',
            'outgoing' => '傳出',
            'slash' => '斜線指令',
            'inbound' => '傳入',
            'auto_accept' => '自動提醒－未接收',
            'auto_due' => '自動提醒－繳交',
            'auto_due_pre' => '自動提醒－繳交前',
            'auto_overdue' => '自動提醒－遲交',
        ];
    }

    /** @return string[] */
    public static function overdueEventTypes(): array
    {
        return ['auto_overdue', 'auto_due_overdue'];
    }

    /** @return array<string, string> */
    public static function filterStatusOptions(): array
    {
        return [
            '' => '全部狀態',
            'processed' => '已處理',
            'failed' => '失敗',
            'ignored' => '已忽略',
        ];
    }

    /**
     * 從 payload 取出 Synology Chat 私訊對象（synology_user_id 列表）。
     *
     * @return int[]
     */
    public function recipientSynologyUserIds(): array
    {
        $payload = $this->payload_json ?? [];
        $raw = $payload['user_ids'] ?? data_get($payload, 'result.user_ids') ?? [];

        if (! is_array($raw)) {
            return [];
        }

        return array_values(array_unique(array_filter(
            array_map(static fn ($id) => (int) $id, $raw),
            static fn (int $id) => $id > 0
        )));
    }

    public function formatRecipientsLabel(Collection $usersBySynologyId): string
    {
        $labels = [];

        foreach ($this->recipientSynologyUserIds() as $synologyUserId) {
            $user = $usersBySynologyId->get($synologyUserId);
            if ($user !== null && trim((string) ($user->name ?? '')) !== '') {
                $labels[] = $user->name . '（' . $synologyUserId . '）';
            } else {
                $labels[] = '未對應使用者（' . $synologyUserId . '）';
            }
        }

        $channelId = trim((string) ($this->channel_id ?? ''));
        if ($channelId !== '') {
            $labels[] = '頻道（' . $channelId . '）';
        }

        return $labels === [] ? '-' : implode('、', $labels);
    }

    /** 管理者檢視用：實際發送／接收的訊息內容（非 JSON）。 */
    public function displayMessageContent(): string
    {
        $text = $this->resolveRawMessageContent();
        if ($text === '') {
            return '（此筆記錄無訊息內容）';
        }

        return $this->normalizeMessageForDisplay($text);
    }

    protected function resolveRawMessageContent(): string
    {
        $text = trim((string) ($this->text ?? ''));
        if ($text !== '') {
            return $text;
        }

        $payload = $this->payload_json ?? [];
        if (! is_array($payload)) {
            return '';
        }

        return trim((string) ($payload['text'] ?? $payload['message'] ?? ''));
    }

    protected function normalizeMessageForDisplay(string $text): string
    {
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $lines = explode("\n", $text);

        while ($lines !== [] && trim($lines[0]) === '') {
            array_shift($lines);
        }

        while ($lines !== [] && trim($lines[array_key_last($lines)]) === '') {
            array_pop($lines);
        }

        return implode("\n", $lines);
    }

    /** 發送失敗時是否可展開查看 payload。 */
    public function shouldShowFailurePayload(): bool
    {
        if (trim((string) ($this->error_message ?? '')) === '') {
            return false;
        }

        $payload = $this->payload_json;
        return is_array($payload) && $payload !== [];
    }

    /** Synology API 錯誤摘要（code + errors），無則 null。 */
    public function synologyErrorSummary(): ?string
    {
        $code = (int) data_get($this->payload_json, 'result.data.error.code', 0);
        if ($code === 0) {
            return null;
        }

        $errors = trim((string) data_get($this->payload_json, 'result.data.error.errors', ''));
        $hint = self::synologyErrorHint($code);
        $line = '錯誤碼 ' . $code;
        if ($errors !== '') {
            $line .= '：' . $errors;
        }
        if ($hint !== '') {
            $line .= '（' . $hint . '）';
        }

        return $line;
    }

    /** 失敗記錄用：格式化 payload JSON 供管理者檢視。 */
    public function displayFailurePayloadJson(): string
    {
        $payload = $this->payload_json ?? [];
        if (! is_array($payload) || $payload === []) {
            return '（無 payload）';
        }

        $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return $encoded !== false ? $encoded : '（payload 無法解析）';
    }

    protected static function synologyErrorHint(int $code): string
    {
        return match ($code) {
            407 => '請確認 user_ids 與 @ 提及是否有效',
            410 => '訊息過長，請縮短或拆段發送',
            800 => '無發送目標，請設定 channel_id 或 user_ids',
            default => '',
        };
    }
}
