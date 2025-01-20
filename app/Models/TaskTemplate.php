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
}
