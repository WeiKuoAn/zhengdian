<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    protected $table = 'task_item';
    protected $fillable = [
        'task_id',
        'user_id',
        'context',
        'start_time',
        'end_time',
        'done_time',
        'status',
        'seq'
    ];
    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function task_data()
    {
        return $this->hasOne('App\Models\Task', 'id', 'task_id');
    }

    public function task_template_data()
    {
        return $this->hasOne('App\Models\TaskTemplate', 'task_id', 'template_id');
    }

    public function status()
    {
        $status = [ '' => '無','0' => '已發送，待確認', '1' => '已接收', '2' => '執行中', '9' => '已完成'];
        return $status[$this->status];
    }

}
