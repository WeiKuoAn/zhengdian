<?php

namespace App\Services;

use App\Models\CustProject;
use App\Models\TaskTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DispatchNotificationService
{
    /** @var string[] */
    protected array $skipped = [];

    public function resetSkipped(): void
    {
        $this->skipped = [];
    }

    /** @return string[] */
    public function skippedNames(): array
    {
        return array_values(array_unique($this->skipped));
    }

    public function skippedWarningMessage(): ?string
    {
        $skipped = $this->skippedNames();
        if ($skipped === []) {
            return null;
        }

        return '以下執行人未設定 Synology Chat ID，無法發送派工通知：' . implode('、', $skipped);
    }

    /** @param array<int, array{id?: int, name?: string}> $executors */
    public function normalizeExecutorRows(array $executors): array
    {
        return collect($executors)
            ->map(function ($row) {
                return [
                    'id' => (int) ($row['id'] ?? 0),
                    'name' => trim((string) ($row['name'] ?? '')),
                ];
            })
            ->filter(fn ($row) => $row['id'] > 0 || $row['name'] !== '')
            ->sortBy([
                ['id', 'asc'],
                ['name', 'asc'],
            ])
            ->values()
            ->all();
    }

    /** @param array<int, array{id?: int, name?: string}> $oldExecutors */
    /** @param array<int, array{id?: int, name?: string}> $newExecutors */
    public function shouldSend(
        ?string $oldDate,
        ?string $oldContent,
        array $oldExecutors,
        ?string $newDate,
        ?string $newContent,
        array $newExecutors
    ): bool {
        $normalizeDate = static fn ($date) => trim((string) $date);
        $normalizeContent = static fn ($content) => trim((string) $content);

        return $normalizeDate($oldDate) !== $normalizeDate($newDate)
            || $normalizeContent($oldContent) !== $normalizeContent($newContent)
            || $this->normalizeExecutorRows($oldExecutors) !== $this->normalizeExecutorRows($newExecutors);
    }

    public function buildDispatchItemLabel(TaskTemplate $template): string
    {
        $template->loadMissing('check_status_data');
        $stageName = trim((string) (optional($template->check_status_data)->name ?? ''));

        return $stageName !== ''
            ? '【' . $stageName . '】' . $template->name
            : (string) $template->name;
    }

    /**
     * @param array<int, array{id?: int, name?: string}> $executors
     */
    public function sendForProject(
        CustProject $project,
        string $taskName,
        string $scheduledDate,
        string $dispatchContent,
        array $executors
    ): void {
        $hasSynologyUserId = Schema::hasColumn('users', 'synology_user_id');

        $executorData = collect($executors)
            ->filter(fn ($row) => !empty($row['name']))
            ->unique('id')
            ->values()
            ->map(function ($row) use ($hasSynologyUserId) {
                $name = (string) $row['name'];
                $userId = (int) ($row['id'] ?? 0);
                $chatUserId = null;
                if ($hasSynologyUserId) {
                    if ($userId > 0) {
                        $chatUserId = User::where('id', $userId)->value('synology_user_id');
                    }
                    if ($chatUserId === null && $name !== '') {
                        $chatUserId = User::where('name', $name)
                            ->whereNotNull('synology_user_id')
                            ->value('synology_user_id');
                    }
                }

                return [
                    'mention' => '@' . $name,
                    'chat_id' => $chatUserId,
                    'user_id' => $userId,
                    'name' => $name,
                ];
            });

        $bodyLines = [
            '專案網址：' . route('project.plan', $project->id),
            '表定時間：' . $scheduledDate,
            '專案名稱：' . ($project->name ?? ''),
            '派工項目：' . $taskName,
            '派工內容：' . $dispatchContent,
        ];

        $chat = app(ChatWebhookService::class);
        foreach ($executorData as $executor) {
            $chatUserId = (int) ($executor['chat_id'] ?? 0);
            $executorName = (string) ($executor['name'] ?? '');
            $executorUserId = (int) ($executor['user_id'] ?? 0) ?: null;

            if ($chatUserId <= 0) {
                if ($executorName !== '') {
                    $this->skipped[] = $executorName;
                    $chat->logDispatchNotificationSkipped(
                        $executorName,
                        (int) $project->id,
                        $executorUserId,
                        $taskName
                    );
                }
                continue;
            }

            $textLines = [];
            $mention = trim((string) ($executor['mention'] ?? ''));
            if ($mention !== '') {
                $textLines[] = $mention;
            }
            $text = implode("\n", array_merge($textLines, $bodyLines));

            $result = $chat->sendIncomingToSynology($text, [$chatUserId]);
            $chat->logDispatchNotification(
                $text,
                [$chatUserId],
                $result,
                (int) $project->id,
                $executorUserId,
                $taskName
            );
            if (!($result['success'] ?? false)) {
                Log::warning('dispatch_webhook_send_failed', [
                    'project_id' => $project->id,
                    'task_name' => $taskName,
                    'synology_user_id' => $chatUserId,
                    'message' => $result['message'] ?? 'unknown error',
                ]);
            }
        }
    }
}
