<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContact extends Model
{
    use HasFactory;
    protected $table = 'project_contact';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'department', 'job', 'fax',
        'context', 'mobile', 'phone', 'experience', 'email','salary','past_experience','month'
    ];
}
