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
    ];
    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function task_data()
    {
        return $this->hasOne('App\Models\Task', 'id', 'task_id');
    }
}
