<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskEstimatedEndAdjustment extends Model
{
    protected $table = 'task_estimated_end_adjustments';

    protected $fillable = [
        'task_id',
        'adjusted_estimated_end',
        'previous_adjusted_estimated_end',
        'note',
        'created_by',
    ];

    protected $casts = [
        'adjusted_estimated_end' => 'datetime',
        'previous_adjusted_estimated_end' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
