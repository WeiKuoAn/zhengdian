<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    protected $fillable = [
        'name',
        'template_id',
        'check_status_id',
        'created_by',
        'assigned_to',
        'comments',
        'status',
        'start_time',
        'estimated_end',
        'actual_end',
        'priority',
        'type',
    ];

    public function task_template_data()
    {
        return $this->hasOne('App\Models\TaskTemplate', 'id', 'template_id');
    }
    public function check_status_data()
    {
        return $this->hasOne('App\Models\CheckStatus', 'id', 'check_status_id');
    }
    public function task_user()
    {
        return $this->hasMany('App\Models\TaskItem', 'task_id', 'id');
    }
}
