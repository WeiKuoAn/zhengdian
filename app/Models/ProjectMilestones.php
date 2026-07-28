<?php

namespace App\Models;

use App\Support\PlanOrderDateCascade;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ProjectMilestones extends Model
{
    use HasFactory;

    protected $table = 'project_milestones';
    protected $fillable = [
        'project_id', 'milestone_type', 'milestone_date', 'formal_date', 'status','order_date','category_id','linked_task_id'
    ];
    public function project_data()
    {
        return $this->hasOne('App\Models\CustProject', 'id', 'project_id');
    }

    public function task_data()
    {
        return $this->hasOne('App\Models\TaskTemplate', 'id', 'milestone_type');
    }

    public function calendar_category_data()
    {
        return $this->hasOne('App\Models\CalendarCategory', 'id', 'category_id');
    }

    public function linked_task()
    {
        return $this->hasOne('App\Models\Task', 'id', 'linked_task_id');
    }

    /**
     * 派工列表／專案內派工新增或更新時：連結 milestone，並把預計完成日寫入表訂時間。
     */
    public static function syncLinkedTaskFromDispatch(Task $task, ?int $oldProjectId = null, ?int $oldTemplateId = null): void
    {
        if (! Schema::hasColumn('project_milestones', 'linked_task_id')) {
            return;
        }

        $projectId = (int) ($task->project_id ?? 0);
        $templateId = (int) ($task->template_id ?? 0);
        if ($projectId <= 0 || $templateId <= 0) {
            return;
        }

        if (($oldProjectId && $oldProjectId !== $projectId) || ($oldTemplateId && $oldTemplateId !== $templateId)) {
            static::query()
                ->where('project_id', $oldProjectId ?: $projectId)
                ->where('milestone_type', $oldTemplateId ?: $templateId)
                ->where('linked_task_id', $task->id)
                ->update(['linked_task_id' => null]);
        }

        $row = static::query()->firstOrNew([
            'project_id' => $projectId,
            'milestone_type' => $templateId,
        ]);

        if (empty($row->category_id)) {
            $row->category_id = '1';
        }
        $row->linked_task_id = $task->id;

        $orderDate = static::dateFromDateTime($task->estimated_end);
        if ($orderDate !== null) {
            $row->order_date = $orderDate;
        }

        $row->save();

        PlanOrderDateCascade::fillEmptyOrderDates($projectId);
    }

    /**
     * 派工確認完成後：把實際完成日時寫回專案排程「實際完成時間」。
     */
    public static function syncFormalDateFromTask(Task $task): void
    {
        if (! Schema::hasColumn('project_milestones', 'formal_date')) {
            return;
        }

        $task->loadMissing('items');
        $formalDateTime = null;

        if ($task->items->isNotEmpty()) {
            $lastItem = $task->items->sortBy('id')->last();
            $lastStatus = (int) (optional($lastItem)->status ?? 0);
            if ($lastItem && ! empty($lastItem->end_time) && in_array($lastStatus, [8, 9], true)) {
                $formalDateTime = static::dateTimeFromValue($lastItem->end_time);
            }
        }

        if ($formalDateTime === null) {
            $formalDateTime = static::dateTimeFromValue($task->actual_end);
        }

        if ($formalDateTime === null) {
            return;
        }

        $query = static::query()->where('linked_task_id', $task->id);
        if ($query->exists()) {
            $query->update(['formal_date' => $formalDateTime]);

            return;
        }

        $projectId = (int) ($task->project_id ?? 0);
        $templateId = (int) ($task->template_id ?? 0);
        if ($projectId <= 0 || $templateId <= 0) {
            return;
        }

        $row = static::query()->firstOrNew([
            'project_id' => $projectId,
            'milestone_type' => $templateId,
        ]);
        if (empty($row->category_id)) {
            $row->category_id = '1';
        }
        $row->linked_task_id = $task->id;
        $row->formal_date = $formalDateTime;
        $row->save();
    }

    protected static function dateFromDateTime(mixed $value): ?string
    {
        $dt = static::dateTimeFromValue($value);

        return $dt ? substr($dt, 0, 10) : null;
    }

    protected static function dateTimeFromValue(mixed $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
