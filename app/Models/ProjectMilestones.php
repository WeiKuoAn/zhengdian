<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMilestones extends Model
{
    use HasFactory;

    protected $table = 'project_milestones';
    protected $fillable = [
        'project_id', 'milestone_type', 'milestone_date', 'formal_date', 'status'
    ];
    public function project_data()
    {
        return $this->hasOne('App\Models\CustProject', 'id', 'project_id');
    }
}