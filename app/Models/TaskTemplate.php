<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
    protected $table = 'task_templates';
    protected $fillable = [
        'check_status_parent_id',
        'check_status_id',
        'name',
        'description',
        'duration_days',
        'duration_hours',
        'status',
        'seq',
        'created_by'
    ];

    public function check_status_data()
    {
        return $this->hasOne('App\Models\CheckStatus', 'id', 'check_status_id');
    }

    public function check_status_parent_data()
    {
        return $this->hasOne('App\Models\CheckStatus', 'id', 'check_status_parent_id');
    }

    public static function compareScheduleOrder(self $a, self $b): int
    {
        $parentCompare = strnatcmp(
            (string) optional($a->check_status_parent_data)->seq,
            (string) optional($b->check_status_parent_data)->seq
        );
        if ($parentCompare !== 0) {
            return $parentCompare;
        }

        $stageCompare = strnatcmp(
            (string) optional($a->check_status_data)->seq,
            (string) optional($b->check_status_data)->seq
        );
        if ($stageCompare !== 0) {
            return $stageCompare;
        }

        return strnatcmp((string) ($a->seq ?? ''), (string) ($b->seq ?? ''));
    }

    /**
     * @param \Illuminate\Support\Collection<int, self>|\Illuminate\Database\Eloquent\Collection<int, self> $templates
     * @return \Illuminate\Support\Collection<int, self>
     */
    public static function sortByScheduleOrder($templates)
    {
        return $templates->sort([self::class, 'compareScheduleOrder'])->values();
    }

    public function scopeListed($query)
    {
        return $query->where(function ($query) {
            $query->where('status', 'up')->orWhereNull('status');
        });
    }

    public function scopeByListStatusFilter($query, ?string $filter)
    {
        if ($filter === 'up') {
            return $query->where(function ($query) {
                $query->where('status', 'up')->orWhereNull('status');
            });
        }

        if ($filter === 'down') {
            return $query->where('status', 'down');
        }

        return $query;
    }
}
