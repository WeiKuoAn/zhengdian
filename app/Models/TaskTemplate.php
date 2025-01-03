<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
    protected $table = 'task_templates';
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'seq',
        'created_by'
    ];
}
