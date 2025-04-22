<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir09HostExperience extends Model
{
    use HasFactory;
    protected $table = 'sbir09_host_experience';

    protected $fillable = [
        'user_id',
        'project_id',
        'host_id',
        'company',
        'work_period',
        'department',
        'position',
    ];
}
