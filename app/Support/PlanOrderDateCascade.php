<?php

namespace App\Support;

use App\Models\ProjectMilestones;
use App\Models\TaskTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

/**
 * 專案排程「表訂時間」往下連動：
 * - 有值的列當錨點，只往後推算空白列
 * - 不回推、不覆蓋前方或已有表訂日的列
 */
class PlanOrderDateCascade
{
    public static function fillEmptyOrderDates(int $projectId): void
    {
        if ($projectId <= 0 || ! Schema::hasTable('project_milestones')) {
            return;
        }

        $templates = TaskTemplate::sortByScheduleOrder(
            TaskTemplate::with(['check_status_data'])->listed()->get()
        );
        if ($templates->isEmpty()) {
            return;
        }

        $milestones = ProjectMilestones::query()
            ->where('project_id', $projectId)
            ->get()
            ->keyBy(fn ($row) => (int) $row->milestone_type);

        $previousEnd = null;

        foreach ($templates->values() as $index => $template) {
            $templateId = (int) $template->id;
            $row = $milestones->get($templateId);
            $orderDate = trim((string) ($row->order_date ?? ''));

            if ($orderDate === '' && $previousEnd instanceof Carbon) {
                $linkDays = (int) (optional($template->check_status_data)->duration_days ?? 0);
                $orderDate = self::nextOrderDateFromPreviousEnd($previousEnd, $linkDays);

                $row = $row ?: new ProjectMilestones([
                    'project_id' => $projectId,
                    'milestone_type' => $templateId,
                ]);
                if (empty($row->category_id)) {
                    $row->category_id = '1';
                }
                $row->project_id = $projectId;
                $row->milestone_type = $templateId;
                $row->order_date = $orderDate;
                $row->save();
                $milestones->put($templateId, $row);
            }

            if ($orderDate === '') {
                $previousEnd = null;
                continue;
            }

            // 已有連結派工時，以下一列連動基準採用派工預計完成時間
            $linkedTaskId = (int) ($row->linked_task_id ?? 0);
            if ($linkedTaskId > 0) {
                $linkedTask = \App\Models\Task::query()->find($linkedTaskId);
                if ($linkedTask && ! empty($linkedTask->estimated_end)) {
                    try {
                        $previousEnd = Carbon::parse($linkedTask->estimated_end);
                        continue;
                    } catch (\Throwable $e) {
                        // fall through
                    }
                }
            }

            $durationMinutes = (int) round(max(0, (float) ($template->duration_hours ?? (($template->duration_days ?? 0) * 8))) * 60);
            $fromChain = $index > 0 && $previousEnd !== null;
            $start = $fromChain
                ? $previousEnd->copy()
                : Carbon::parse($orderDate)->setTime(9, 0, 0);
            $previousEnd = self::addWorkingMinutesSkippingLunch($start, $durationMinutes, ! $fromChain);
        }
    }

    protected static function nextOrderDateFromPreviousEnd(Carbon $previousEnd, int $linkDays): string
    {
        $d = $previousEnd->copy()->startOfDay()->setTime(12, 0, 0);
        while (self::isWeekend($d)) {
            $d->addDay();
        }

        $iso = $d->format('Y-m-d');
        if ($linkDays > 1) {
            $iso = self::addBusinessDaysInclusive($iso, $linkDays);
        }

        return $iso;
    }

    protected static function addBusinessDaysInclusive(string $isoDateStr, int $days): string
    {
        if ($days <= 0) {
            return $isoDateStr;
        }

        $d = Carbon::parse($isoDateStr)->setTime(12, 0, 0);
        while (self::isWeekend($d)) {
            $d->addDay();
        }

        $remaining = $days - 1;
        while ($remaining > 0) {
            $d->addDay();
            if (self::isWeekend($d)) {
                continue;
            }
            $remaining--;
        }

        return $d->format('Y-m-d');
    }

    protected static function addWorkingMinutesSkippingLunch(Carbon $startAt, int $minutes, bool $clampToWorkStart = true): Carbon
    {
        $minutes = max($minutes, 0);
        $t = $startAt->copy();

        while ($minutes > 0) {
            $workStart = $t->copy()->setTime(9, 0, 0);
            $lunchStart = $t->copy()->setTime(12, 0, 0);
            $lunchEnd = $t->copy()->setTime(13, 0, 0);
            $workEnd = $t->copy()->setTime(18, 0, 0);

            // 承接前一段完成時間時不強制拉到 09:00（例：08:00 + 0.5h = 08:30）
            if ($clampToWorkStart && $t->lt($workStart)) {
                $t = $workStart;
                continue;
            }
            if ($t->greaterThanOrEqualTo($lunchStart) && $t->lt($lunchEnd)) {
                $t = $lunchEnd;
                continue;
            }
            if ($t->greaterThanOrEqualTo($workEnd)) {
                $t = $t->copy()->addDay()->setTime(9, 0, 0);
                continue;
            }

            $segmentEnd = $t->lt($lunchStart) ? $lunchStart : $workEnd;
            $available = $t->diffInMinutes($segmentEnd);
            if ($available <= 0) {
                $t = $segmentEnd;
                continue;
            }

            $consume = min($minutes, $available);
            $t = $t->copy()->addMinutes($consume);
            $minutes -= $consume;
        }

        return $t;
    }

    protected static function isWeekend(Carbon $d): bool
    {
        return $d->isWeekend();
    }
}
