<?php

namespace App\Console\Commands;

use App\Models\DispatchReminderLog;
use App\Models\DispatchReminderSetting;
use App\Models\ChatWebhookEvent;
use App\Models\Task;
use App\Models\TaskItem;
use App\Services\ChatWebhookService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendDispatchReminders extends Command
{
    protected $signature = 'dispatch:send-reminders {--at= : 模擬執行時間，格式例如 "2026-05-05 10:00"}';

    protected $description = 'Send dispatch acceptance and due reminder messages';

    protected int $fixedNotifyUserId = 40;

    protected ?DispatchReminderSetting $setting = null;

    public function handle(ChatWebhookService $chat): int
    {
        $at = (string) ($this->option('at') ?? '');
        $now = Carbon::now();
        if (trim($at) !== '') {
            try {
                $now = Carbon::parse($at);
            } catch (\Throwable $e) {
                $this->error('無效的 --at 時間格式，請用例如：2026-05-05 10:00');
                return self::INVALID;
            }
        }

        $acceptCount = $this->sendAcceptanceReminders($chat, $now);
        $dueCount = $this->sendDueAndOverdueReminders($chat, $now);

        $this->info("dispatch reminders sent: acceptance={$acceptCount}, due={$dueCount}, at={$now->format('Y-m-d H:i:s')}");
        return self::SUCCESS;
    }

    protected function sendAcceptanceReminders(ChatWebhookService $chat, Carbon $now): int
    {
        $interval = max((int) $this->settingValue('accept_interval_minutes', (int) config('dispatch_reminder.accept_interval_minutes', 60)), 1);

        $items = TaskItem::query()
            ->where('status', '0')
            ->whereNotNull('start_time')
            ->with([
                'user_data',
                'task_data.project_data.user_data',
                'task_data.task_template_data',
                'task_data.items.user_data',
            ])
            ->get();

        $sent = 0;
        $buckets = [];
        foreach ($items as $item) {
            $dispatchAt = $this->asCarbon($item->start_time);
            if ($dispatchAt === null) {
                continue;
            }

            $firstDue = $dispatchAt->copy()->addMinutes($interval);
            $slot = $this->latestSlot($firstDue, $interval, $now);
            if ($slot === null || !$this->isWithinNotifyWindow($slot)) {
                continue;
            }

            $key = 'accept:' . $item->id . ':' . $slot->format('YmdHi');
            if (!$this->claimReminder($key, 'accept', $item->task_id, $item->id, $slot)) {
                continue;
            }

            $task = $item->task_data;
            if ($task === null) {
                continue;
            }

            $mentions = $this->buildMentionText($task->items);
            $projectName = $this->buildProjectName($task);
            $taskName = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');

            $message = $this->renderTemplate('accept_template', [
                'mentions' => $mentions,
                'project_name' => $projectName,
                'task_name' => $taskName,
                'task_url' => 'https://zhengdian.com.tw/task',
                'due_time' => '',
                'cutoff_time' => '',
            ]);

            $userIds = $this->buildRecipientUserIds($task->items);
            $bucketKey = implode(',', $userIds);
            if (!isset($buckets[$bucketKey])) {
                $buckets[$bucketKey] = ['user_ids' => $userIds, 'messages' => []];
            }
            $buckets[$bucketKey]['messages'][] = $message;
        }

        foreach ($buckets as $bucket) {
            $combinedMessage = implode("\n\n", $bucket['messages']);
            if ($this->sendReminderMessageToUserIds($chat, $combinedMessage, $bucket['user_ids'], 'accept')) {
                $sent += count($bucket['messages']);
            }
        }

        return $sent;
    }

    protected function sendDueAndOverdueReminders(ChatWebhookService $chat, Carbon $now): int
    {
        $before = max((int) $this->settingValue('due_before_minutes', (int) config('dispatch_reminder.due_before_minutes', 120)), 1);
        $overdueInterval = max((int) $this->settingValue('overdue_interval_minutes', (int) config('dispatch_reminder.overdue_interval_minutes', 120)), 1);

        $tasks = Task::query()
            ->whereNotIn('status', ['8', '9', 8, 9])
            ->whereNotNull('estimated_end')
            ->with(['project_data.user_data', 'task_template_data', 'items.user_data'])
            ->get();

        $sent = 0;
        $dueBuckets = [];
        $overdueBuckets = [];
        foreach ($tasks as $task) {
            $dueAt = $this->asCarbon($task->estimated_end);
            if ($dueAt === null) {
                continue;
            }

            // 交件前提醒（只發一次）
            $preAt = $dueAt->copy()->subMinutes($before);
            if ($now->greaterThanOrEqualTo($preAt) && $this->isWithinNotifyWindow($preAt)) {
                $preKey = 'due-pre:' . $task->id . ':' . $preAt->format('YmdHi');
                if ($this->claimReminder($preKey, 'due_pre', $task->id, null, $preAt)) {
                    $mentions = $this->buildMentionText($task->items);
                    $projectName = $this->buildProjectName($task);
                    $taskName = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');
                    $message = $this->renderTemplate('due_template', [
                        'mentions' => $mentions,
                        'project_name' => $projectName,
                        'task_name' => $taskName,
                        'task_url' => 'https://zhengdian.com.tw/task',
                        'due_time' => $dueAt->format('Y-m-d H:i'),
                        'cutoff_time' => '',
                    ]);
                    $userIds = $this->buildRecipientUserIds($task->items);
                    $bucketKey = implode(',', $userIds);
                    if (!isset($dueBuckets[$bucketKey])) {
                        $dueBuckets[$bucketKey] = ['user_ids' => $userIds, 'messages' => []];
                    }
                    $dueBuckets[$bucketKey]['messages'][] = $message;
                }
            }

            // 遲交提醒（每兩小時；超過 cutoff 不提醒）
            $firstOverdue = $dueAt->copy()->addMinutes($overdueInterval);
            $slot = $this->latestSlot($firstOverdue, $overdueInterval, $now);
            if ($slot === null || !$this->isWithinNotifyWindow($slot)) {
                continue;
            }

            $cutoff = $this->dateTimeFor($dueAt, (string) $this->settingValue('overdue_cutoff_time', (string) config('dispatch_reminder.overdue_cutoff_time', '18:00')));
            if ($slot->greaterThan($cutoff)) {
                continue;
            }

            $overdueKey = 'due-over:' . $task->id . ':' . $slot->format('YmdHi');
            if (!$this->claimReminder($overdueKey, 'due_overdue', $task->id, null, $slot)) {
                continue;
            }

            $mentions = $this->buildMentionText($task->items);
            $projectName = $this->buildProjectName($task);
            $taskName = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');
            $message = $this->renderTemplate('overdue_template', [
                'mentions' => $mentions,
                'project_name' => $projectName,
                'task_name' => $taskName,
                'task_url' => 'https://zhengdian.com.tw/task',
                'due_time' => $dueAt->format('Y-m-d H:i'),
                'cutoff_time' => $cutoff->format('H:i'),
            ]);

            $userIds = $this->buildRecipientUserIds($task->items);
            $bucketKey = implode(',', $userIds);
            if (!isset($overdueBuckets[$bucketKey])) {
                $overdueBuckets[$bucketKey] = ['user_ids' => $userIds, 'messages' => []];
            }
            $overdueBuckets[$bucketKey]['messages'][] = $message;
        }

        foreach ($dueBuckets as $bucket) {
            $combinedMessage = implode("\n\n", $bucket['messages']);
            if ($this->sendReminderMessageToUserIds($chat, $combinedMessage, $bucket['user_ids'], 'due')) {
                $sent += count($bucket['messages']);
            }
        }

        foreach ($overdueBuckets as $bucket) {
            $combinedMessage = implode("\n\n", $bucket['messages']);
            if ($this->sendReminderMessageToUserIds($chat, $combinedMessage, $bucket['user_ids'], 'overdue')) {
                $sent += count($bucket['messages']);
            }
        }

        return $sent;
    }

    protected function sendReminderMessage(
        ChatWebhookService $chat,
        string $text,
        Collection $items,
        string $reminderType,
        ?Task $task = null,
        ?TaskItem $item = null
    ): bool
    {
        $userIds = $this->buildRecipientUserIds($items);

        $result = $chat->sendIncomingToSynology($text, $userIds);
        $this->logWebhookEvent($reminderType, $text, $userIds, $result, $task, $item);
        if (!($result['success'] ?? false)) {
            Log::warning('dispatch_reminder_send_failed', [
                'message' => $result['message'] ?? 'unknown',
                'result' => $result,
            ]);
            return false;
        }

        return true;
    }

    protected function sendReminderMessageToUserIds(
        ChatWebhookService $chat,
        string $text,
        array $userIds,
        string $reminderType
    ): bool {
        $result = $chat->sendIncomingToSynology($text, $userIds);
        $this->logWebhookEvent($reminderType, $text, $userIds, $result, null, null);
        if (!($result['success'] ?? false)) {
            Log::warning('dispatch_reminder_send_failed', [
                'message' => $result['message'] ?? 'unknown',
                'result' => $result,
            ]);
            return false;
        }

        return true;
    }

    protected function buildRecipientUserIds(Collection $items): array
    {
        return $items
            ->map(fn ($item) => (int) (optional($item->user_data)->synology_user_id ?? 0))
            ->filter(fn ($id) => $id > 0)
            ->push($this->fixedNotifyUserId)
            ->unique()
            ->values()
            ->all();
    }

    protected function buildMentionText(Collection $items): string
    {
        return $items
            ->map(fn ($item) => trim((string) (optional($item->user_data)->name ?? '')))
            ->filter()
            ->unique()
            ->map(fn ($name) => '@' . $name)
            ->implode(' ');
    }

    protected function buildProjectName(Task $task): string
    {
        $prefix = (string) (optional(optional($task->project_data)->user_data)->name ?? '');
        $projectName = (string) (optional($task->project_data)->name ?? '未命名專案');
        return $prefix . $projectName;
    }

    protected function isWithinNotifyWindow(Carbon $time): bool
    {
        $start = $this->dateTimeFor($time, (string) $this->settingValue('window_start', (string) config('dispatch_reminder.window_start', '09:00')));
        $end = $this->dateTimeFor($time, (string) $this->settingValue('window_end', (string) config('dispatch_reminder.window_end', '18:00')));
        return $time->betweenIncluded($start, $end);
    }

    protected function dateTimeFor(Carbon $baseDate, string $hm): Carbon
    {
        [$h, $m] = array_pad(explode(':', $hm), 2, '00');
        return $baseDate->copy()->setTime((int) $h, (int) $m, 0);
    }

    protected function latestSlot(Carbon $startAt, int $intervalMinutes, Carbon $now): ?Carbon
    {
        if ($now->lt($startAt)) {
            return null;
        }
        $elapsed = $startAt->diffInMinutes($now);
        $steps = intdiv($elapsed, $intervalMinutes);
        return $startAt->copy()->addMinutes($steps * $intervalMinutes);
    }

    protected function claimReminder(string $key, string $type, ?int $taskId, ?int $taskItemId, Carbon $slot): bool
    {
        try {
            DispatchReminderLog::query()->create([
                'reminder_key' => $key,
                'reminder_type' => $type,
                'task_id' => $taskId,
                'task_item_id' => $taskItemId,
                'reminder_slot_at' => $slot,
                'notified_at' => Carbon::now(),
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function asCarbon($value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function settingValue(string $field, mixed $fallback): mixed
    {
        if ($this->setting === null) {
            $this->setting = DispatchReminderSetting::query()->first();
        }

        if ($this->setting === null) {
            return $fallback;
        }

        $value = $this->setting->getAttribute($field);
        return ($value === null || $value === '') ? $fallback : $value;
    }

    protected function renderTemplate(string $settingField, array $vars): string
    {
        $default = (string) config('dispatch_reminder.' . $settingField, '');
        $template = (string) $this->settingValue($settingField, $default);
        if (trim($template) === '') {
            $template = $default;
        }

        $replace = [];
        foreach ($vars as $key => $value) {
            $replace['{' . $key . '}'] = (string) $value;
        }

        return strtr($template, $replace);
    }

    protected function logWebhookEvent(
        string $reminderType,
        string $text,
        array $userIds,
        array $result,
        ?Task $task,
        ?TaskItem $item
    ): void {
        ChatWebhookEvent::query()->create([
            'provider' => (string) config('chat_webhook.provider', 'synology_chat'),
            'event_type' => 'auto_' . $reminderType,
            'request_id' => (string) Str::uuid(),
            'user_id_external' => $item?->user_id ? (string) $item->user_id : null,
            'username' => 'system-reminder',
            'channel_id' => (string) config('chat_webhook.synology_dispatch_channel_id', ''),
            'command' => '/auto-reminder ' . $reminderType,
            'text' => $text,
            'payload_json' => [
                'user_ids' => $userIds,
                'task_id' => $task?->id,
                'task_item_id' => $item?->id,
                'result' => $result,
            ],
            'headers_json' => ['source' => 'dispatch:send-reminders'],
            'verified' => true,
            'verify_reason' => 'internal scheduler',
            'status' => ($result['success'] ?? false) ? 'processed' : 'failed',
            'processed_at' => Carbon::now(),
            'error_message' => ($result['success'] ?? false) ? null : ((string) ($result['message'] ?? 'send failed')),
        ]);
    }
}

