<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAccounting extends Model
{
    use HasFactory;
    protected $table = 'project_accounting';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'department', 'job', 
        'context', 'mobile', 'phone', 'experience', 'email','salary','past_experience','month','fax'
    ];
}
