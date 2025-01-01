<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPersonnel extends Model
{
    use HasFactory;
    protected $table = 'project_personnel';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'department', 'job', 
        'context', 'mobile', 'phone', 'experience', 'email','salary','past_experience','month'
    ];
}
