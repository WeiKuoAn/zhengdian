<?php

namespace App\Console\Commands;

use App\Models\DispatchReminderLog;
use App\Models\DispatchReminderSetting;
use App\Models\ChatWebhookEvent;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\User;
use App\Support\DispatchReminderCalendar;
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

    protected string $dispatchReminderStartDate = '2026-05-01 00:00:00';

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

        if (!DispatchReminderCalendar::allowsRemindersToday($this->remindOnHolidaysEnabled(), $now)) {
            $this->info('dispatch reminders skipped: holiday (remind_on_holidays=off), at=' . $now->format('Y-m-d H:i:s'));
            return self::SUCCESS;
        }

        $acceptCount = $this->sendAcceptanceReminders($chat, $now);
        $dueCount = $this->sendDueAndOverdueReminders($chat, $now);

        $this->info("dispatch reminders sent: acceptance={$acceptCount}, due={$dueCount}, at={$now->format('Y-m-d H:i:s')}");
        return self::SUCCESS;
    }

    protected function sendAcceptanceReminders(ChatWebhookService $chat, Carbon $now): int
    {
        $interval = max((int) $this->settingValue('accept_interval_minutes', (int) config('dispatch_reminder.accept_interval_minutes', 60)), 1);
        $lowerBound = Carbon::parse($this->dispatchReminderStartDate);

        $items = TaskItem::query()
            ->where('status', '0')
            ->whereNotNull('start_time')
            ->where('start_time', '>=', $lowerBound)
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

            $projectName = $this->buildProjectName($task);
            $taskName = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');
            $taskNote = trim((string) ($task->comments ?? ''));
            $projectId = (int) ($task->project_id ?? 0);
            $projectPlanUrl = $projectId > 0
                ? ('https://zhengdian.com.tw/project/plan/' . $projectId)
                : 'https://zhengdian.com.tw/task';

            $userIds = $this->buildRecipientUserIds($task->items);
            $bucketKey = implode(',', $userIds);
            if (!isset($buckets[$bucketKey])) {
                $buckets[$bucketKey] = ['user_ids' => $userIds, 'entries' => [], 'mentions' => []];
            }
            foreach ($this->buildMentionNames($task->items) as $mentionName) {
                if (!in_array($mentionName, $buckets[$bucketKey]['mentions'], true)) {
                    $buckets[$bucketKey]['mentions'][] = $mentionName;
                }
            }
            $buckets[$bucketKey]['entries'][] = [
                'project_id' => $projectId,
                'project_name' => $projectName,
                'task_name' => $taskName,
                'task_note' => $taskNote,
                'project_plan_url' => $projectPlanUrl,
                'planned_completion_suffix' => $this->plannedCompletionSuffix($task->estimated_end),
            ];
        }

        foreach ($buckets as $bucket) {
            if ($this->sendCombinedAcceptanceMessages($chat, $bucket['entries'], $bucket['mentions'], $bucket['user_ids'])) {
                $sent += count($bucket['entries']);
            }
        }

        return $sent;
    }

    protected function sendDueAndOverdueReminders(ChatWebhookService $chat, Carbon $now): int
    {
        $before = max((int) $this->settingValue('due_before_minutes', (int) config('dispatch_reminder.due_before_minutes', 120)), 1);
        $overdueInterval = max((int) $this->settingValue('overdue_interval_minutes', (int) config('dispatch_reminder.overdue_interval_minutes', 120)), 1);
        $lowerBound = Carbon::parse($this->dispatchReminderStartDate);

        $tasks = Task::query()
            ->whereNotIn('status', ['8', '9', 8, 9])
            ->whereNotNull('estimated_end')
            ->where('estimated_end', '>=', $lowerBound)
            // 繳交/遲交提醒只針對「已接收」後的派工，避免與未接收提醒重複。
            ->whereHas('items', function ($q) {
                $q->whereIn('status', ['1', '2', 1, 2]);
            })
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
                    $projectName = $this->buildProjectName($task);
                    $taskName = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');
                    $taskNote = trim((string) ($task->comments ?? ''));
                    $projectId = (int) ($task->project_id ?? 0);
                    $projectPlanUrl = $projectId > 0
                        ? ('https://zhengdian.com.tw/project/plan/' . $projectId)
                        : 'https://zhengdian.com.tw/task';
                    $userIds = $this->buildRecipientUserIds($task->items);
                    $bucketKey = implode(',', $userIds);
                    if (!isset($dueBuckets[$bucketKey])) {
                        $dueBuckets[$bucketKey] = ['user_ids' => $userIds, 'entries' => [], 'mentions' => []];
                    }
                    foreach ($this->buildMentionNames($task->items) as $mentionName) {
                        if (!in_array($mentionName, $dueBuckets[$bucketKey]['mentions'], true)) {
                            $dueBuckets[$bucketKey]['mentions'][] = $mentionName;
                        }
                    }
                    $dueBuckets[$bucketKey]['entries'][] = [
                        'project_name' => $projectName,
                        'task_name' => $taskName,
                        'task_note' => $taskNote,
                        'project_plan_url' => $projectPlanUrl,
                        'planned_completion_suffix' => $this->plannedCompletionSuffix($task->estimated_end),
                    ];
                }
            }

            // 遲交提醒：逾表定時間後發送。
            // 表定「當日」：由表定完成時間起每間隔一拍，並限於最晚提醒時間／遲交截止前；
            // 表定「隔日」起：改由每日最早提醒時間起每間隔一拍，同上限制；直至完成。
            if (!$now->greaterThan($dueAt)) {
                continue;
            }

            $slot = $this->overdueReminderSlot($now, $dueAt, $overdueInterval);
            if ($slot === null || !$this->isWithinNotifyWindow($slot)) {
                continue;
            }

            $dayCutoffHm = (string) $this->settingValue('overdue_cutoff_time', (string) config('dispatch_reminder.overdue_cutoff_time', '18:00'));
            $dayWindowEndHm = (string) $this->settingValue('window_end', (string) config('dispatch_reminder.window_end', '18:00'));
            $dayCutoffOverdue = $this->dateTimeFor($slot, $dayCutoffHm);
            $dayCutoffNotify = $this->dateTimeFor($slot, $dayWindowEndHm);
            $dayCutoff = $dayCutoffOverdue->lt($dayCutoffNotify) ? $dayCutoffOverdue : $dayCutoffNotify;
            if ($slot->greaterThan($dayCutoff)) {
                continue;
            }

            $overdueKey = 'due-over:' . $task->id . ':' . $slot->format('YmdHi');
            if (!$this->claimReminder($overdueKey, 'due_overdue', $task->id, null, $slot)) {
                continue;
            }

            $projectName = $this->buildProjectName($task);
            $taskName = (string) (optional($task->task_template_data)->name ?? $task->name ?? '工作項目');
            $taskNote = trim((string) ($task->comments ?? ''));
            $projectId = (int) ($task->project_id ?? 0);
            $projectPlanUrl = $projectId > 0
                ? ('https://zhengdian.com.tw/project/plan/' . $projectId)
                : 'https://zhengdian.com.tw/task';

            $userIds = $this->buildRecipientUserIds($task->items);
            $bucketKey = implode(',', $userIds);
            if (!isset($overdueBuckets[$bucketKey])) {
                $overdueBuckets[$bucketKey] = ['user_ids' => $userIds, 'entries' => [], 'mentions' => []];
            }
            foreach ($this->buildMentionNames($task->items) as $mentionName) {
                if (!in_array($mentionName, $overdueBuckets[$bucketKey]['mentions'], true)) {
                    $overdueBuckets[$bucketKey]['mentions'][] = $mentionName;
                }
            }
            $overdueBuckets[$bucketKey]['entries'][] = [
                'project_name' => $projectName,
                'task_name' => $taskName,
                'task_note' => $taskNote,
                'project_plan_url' => $projectPlanUrl,
                'planned_completion_suffix' => $this->plannedCompletionSuffix($task->estimated_end),
            ];
        }

        foreach ($dueBuckets as $bucket) {
            if ($this->sendCombinedProjectMessages(
                $chat,
                $bucket['entries'],
                $bucket['mentions'],
                $bucket['user_ids'],
                'due',
                '【繳交提醒】',
                '提醒：此工作項目即將到期。'
            )) {
                $sent += count($bucket['entries']);
            }
        }

        foreach ($overdueBuckets as $bucket) {
            $cutoffText = (string) $this->settingValue('overdue_cutoff_time', (string) config('dispatch_reminder.overdue_cutoff_time', '18:00'));
            $intervalText = (string) max((int) $this->settingValue('overdue_interval_minutes', (int) config('dispatch_reminder.overdue_interval_minutes', 120)), 1);
            if ($this->sendCombinedProjectMessages(
                $chat,
                $bucket['entries'],
                $bucket['mentions'],
                $bucket['user_ids'],
                'overdue',
                '【遲交提醒】',
                '提醒：目前已逾期；表定當日自到期時間起、隔日起自最早提醒時間起，於時段內每 ' . $intervalText . ' 分鐘提醒直至完成（超過最晚提醒時間或遲交截止 ' . $cutoffText . ' 不再發送）。'
            )) {
                $sent += count($bucket['entries']);
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
    ): bool {
        $userIds = $this->buildRecipientUserIds($items);
        if ($userIds === []) {
            return false;
        }

        $allOk = true;
        foreach ($userIds as $userId) {
            if (!$this->sendReminderMessageToUserIds($chat, $text, [$userId], $reminderType)) {
                $allOk = false;
            }
        }

        return $allOk;
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

    protected function sendCombinedMessages(
        ChatWebhookService $chat,
        array $messages,
        array $userIds,
        string $reminderType
    ): bool {
        $userIds = $this->normalizeSynologyUserIds($userIds);
        if ($userIds === []) {
            return false;
        }

        $chunks = $this->splitMessagesByLength($messages, 2800);
        $allOk = true;
        foreach ($userIds as $userId) {
            foreach ($chunks as $chunkText) {
                if (!$this->sendReminderMessageToUserIds($chat, $chunkText, [$userId], $reminderType)) {
                    $allOk = false;
                }
            }
        }

        return $allOk;
    }

    protected function splitMessagesByLength(array $messages, int $maxLen): array
    {
        $chunks = [];
        $current = '';
        foreach ($messages as $message) {
            $message = trim((string) $message);
            if ($message === '') {
                continue;
            }
            if ($current === '') {
                $current = $message;
                continue;
            }

            $candidate = $current . "\n\n" . $message;
            if (mb_strlen($candidate) <= $maxLen) {
                $current = $candidate;
                continue;
            }

            $chunks[] = $current;
            $current = $message;
        }

        if ($current !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }

    protected function buildRecipientUserIds(Collection $items): array
    {
        return $items
            ->map(fn ($item) => (int) (optional($item->user_data)->synology_user_id ?? 0))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();
    }

    protected function buildMentionNames(Collection $items): array
    {
        return $items
            ->map(fn ($item) => trim((string) (optional($item->user_data)->name ?? '')))
            ->filter(fn ($name) => $name !== '')
            ->unique()
            ->values()
            ->all();
    }

    /** @param int[] $userIds */
    protected function normalizeSynologyUserIds(array $userIds): array
    {
        return array_values(array_unique(array_filter(
            array_map(static fn ($id) => (int) $id, $userIds),
            static fn (int $id) => $id > 0
        )));
    }

    /** @return string[] */
    protected function mentionNamesForSynologyUserId(int $synologyUserId): array
    {
        $name = trim((string) User::query()
            ->where('synology_user_id', $synologyUserId)
            ->value('name'));

        return $name !== '' ? [$name] : [];
    }

    protected function sendCombinedAcceptanceMessages(
        ChatWebhookService $chat,
        array $entries,
        array $mentionNames,
        array $userIds
    ): bool {
        return $this->sendCombinedProjectMessages(
            $chat,
            $entries,
            $mentionNames,
            $userIds,
            'accept',
            '【派工接收提醒】',
            '提醒：派工後 1 小時內請接收，未接收將每小時提醒一次。'
        );
    }

    protected function sendCombinedProjectMessages(
        ChatWebhookService $chat,
        array $entries,
        array $mentionNames,
        array $userIds,
        string $reminderType,
        string $title,
        string $footer
    ): bool {
        if (empty($entries)) {
            return true;
        }

        $userIds = $this->normalizeSynologyUserIds($userIds);
        if ($userIds === []) {
            return false;
        }

        $allOk = true;
        foreach ($userIds as $userId) {
            if (!$this->sendCombinedProjectMessagesForRecipient(
                $chat,
                $entries,
                $this->mentionNamesForSynologyUserId($userId),
                $userId,
                $reminderType,
                $title,
                $footer
            )) {
                $allOk = false;
            }
        }

        return $allOk;
    }

    protected function sendCombinedProjectMessagesForRecipient(
        ChatWebhookService $chat,
        array $entries,
        array $mentionNames,
        int $synologyUserId,
        string $reminderType,
        string $title,
        string $footer
    ): bool {
        $mentionLine = implode(' ', array_map(fn ($name) => '@' . $name, $mentionNames));
        $projectGroups = [];
        foreach ($entries as $entry) {
            $projectName = (string) ($entry['project_name'] ?? '');
            $projectUrl = (string) ($entry['project_plan_url'] ?? 'https://zhengdian.com.tw/task');
            $projectKey = $projectName . '|' . $projectUrl;
            if (!isset($projectGroups[$projectKey])) {
                $projectGroups[$projectKey] = [
                    'project_name' => $projectName,
                    'project_plan_url' => $projectUrl,
                    'tasks' => [],
                ];
            }
            $taskName = trim((string) ($entry['task_name'] ?? ''));
            $taskNote = trim((string) ($entry['task_note'] ?? ''));
            $plannedSuffix = (string) ($entry['planned_completion_suffix'] ?? '');
            if ($taskName !== '') {
                $projectGroups[$projectKey]['tasks'][] = [
                    'name' => $taskName,
                    'note' => $taskNote,
                    'suffix' => $plannedSuffix,
                ];
            }
        }

        $entryBlocks = [];
        foreach ($projectGroups as $group) {
            $taskLines = [];
            foreach (array_values($group['tasks']) as $index => $row) {
                $taskName = is_array($row) ? trim((string) ($row['name'] ?? '')) : trim((string) $row);
                $taskNote = is_array($row) ? trim((string) ($row['note'] ?? '')) : '';
                $plannedSuffix = is_array($row) ? (string) ($row['suffix'] ?? '') : '';
                $label = $taskName;
                if ($taskNote !== '') {
                    $label .= ' - ' . $taskNote;
                }
                $taskLines[] = '　' . ($index + 1) . '.' . $label . $plannedSuffix;
            }
            if (empty($taskLines)) {
                $taskLines[] = '　1.未命名工作項目' . $this->plannedCompletionSuffix(null);
            }

            $entryBlocks[] = implode("\n", [
                '專案名稱：' . $group['project_name'],
                '工作項目：',
                implode("\n", $taskLines),
                '派工排程連結：' . $group['project_plan_url'],
            ]);
        }

        $chunks = [];
        $currentBlocks = [];
        foreach ($entryBlocks as $block) {
            $testBlocks = array_merge($currentBlocks, [$block]);
            $testMessage = $this->buildAcceptanceChunkMessage($mentionLine, $title, $testBlocks, $footer);
            if (mb_strlen($testMessage) > 2800 && !empty($currentBlocks)) {
                $chunks[] = $this->buildAcceptanceChunkMessage($mentionLine, $title, $currentBlocks, $footer);
                $currentBlocks = [$block];
                continue;
            }
            $currentBlocks = $testBlocks;
        }
        if (!empty($currentBlocks)) {
            $chunks[] = $this->buildAcceptanceChunkMessage($mentionLine, $title, $currentBlocks, $footer);
        }

        foreach ($chunks as $chunk) {
            if (!$this->sendReminderMessageToUserIds($chat, $chunk, [$synologyUserId], $reminderType)) {
                return false;
            }
        }

        return true;
    }

    protected function buildAcceptanceChunkMessage(string $mentionLine, string $title, array $entryBlocks, string $footer): string
    {
        $parts = [];
        if (trim($mentionLine) !== '') {
            $parts[] = $mentionLine;
        }
        $parts[] = $title;
        $parts[] = implode("\n--------------------------------------------------------------------------------\n\n", $entryBlocks);
        $parts[] = $footer;

        return trim(implode("\n", $parts));
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

    /** 附加於工作項目列之後：(表訂完成日期：Y-m-d H:i)，無表訂則標示未設定 */
    protected function plannedCompletionSuffix(mixed $estimatedEnd): string
    {
        $at = $this->asCarbon($estimatedEnd);

        return ' (表訂完成日期：' . ($at === null ? '未設定' : $at->format('Y-m-d H:i')) . ')';
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

    /**
     * 遲交提醒用：逾表定後，「表定當日」自表定完成時間對齊間隔；
     * 「隔日」起改自最早提醒時間對齊；僅在目前時刻已達當日第一個有效格時才回傳。
     */
    protected function overdueReminderSlot(Carbon $now, Carbon $dueAt, int $intervalMinutes): ?Carbon
    {
        $intervalMinutes = max($intervalMinutes, 1);

        $windowStartHm = (string) $this->settingValue('window_start', (string) config('dispatch_reminder.window_start', '09:00'));
        $windowEndHm = (string) $this->settingValue('window_end', (string) config('dispatch_reminder.window_end', '18:00'));
        $overdueCutoffHm = (string) $this->settingValue('overdue_cutoff_time', (string) config('dispatch_reminder.overdue_cutoff_time', '18:00'));

        $windowStartToday = $this->dateTimeFor($now, $windowStartHm);
        $dayEndNotify = $this->dateTimeFor($now, $windowEndHm);
        $dayEndOverdue = $this->dateTimeFor($now, $overdueCutoffHm);
        $dayEnd = $dayEndNotify->lte($dayEndOverdue) ? $dayEndNotify : $dayEndOverdue;

        if ($now->isSameDay($dueAt)) {
            $seriesAnchor = $dueAt->copy();

            if ($seriesAnchor->lt($windowStartToday)) {
                $ahead = $seriesAnchor->diffInMinutes($windowStartToday);
                $n = intdiv($ahead + $intervalMinutes - 1, $intervalMinutes);
                $seriesAnchor = $seriesAnchor->copy()->addMinutes($n * $intervalMinutes);
                if ($seriesAnchor->lt($windowStartToday)) {
                    $seriesAnchor = $windowStartToday->copy();
                }
            }

            if ($now->lt($seriesAnchor)) {
                return null;
            }

            $slot = $this->latestSlot($seriesAnchor, $intervalMinutes, $now);
        } else {
            $seriesAnchor = $windowStartToday->copy();

            if ($now->lt($seriesAnchor)) {
                return null;
            }

            $slot = $this->latestSlot($seriesAnchor, $intervalMinutes, $now);
        }

        if ($slot === null) {
            return null;
        }

        if ($slot->gt($dayEnd)) {
            return null;
        }

        return $slot;
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

    protected function remindOnHolidaysEnabled(): bool
    {
        $value = $this->settingValue('remind_on_holidays', (bool) config('dispatch_reminder.remind_on_holidays', false));

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
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

