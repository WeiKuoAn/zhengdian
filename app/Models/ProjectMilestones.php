<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMilestones extends Model
{
    use HasFactory;

    protected $table = 'project_milestones';
    protected $fillable = [
        'project_id', 'milestone_type', 'milestone_date', 'formal_date', 'status','order_date','category_id'
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
}
