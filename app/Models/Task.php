<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    protected $fillable = [
        'name',
        'project_id',
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
    public function items()
    {
        return $this->hasMany('App\Models\TaskItem', 'task_id', 'id');
    }

    public function project_data()
    {
        return $this->hasOne('App\Models\CustProject', 'id', 'project_id');
    }

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function status()
    {
        $status = [ '' => '無', '1' => '送出派工', '2' => '已接收' , '3' => '執行中', '8' => '人員已完成，待確認', '9' => '已完成'];
        return $status[$this->status];
    }
}
