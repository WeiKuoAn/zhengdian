<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir09HostEducation extends Model
{
    use HasFactory;
    protected $table = 'sbir09_host_education';

    protected $fillable = [
        'user_id',
        'project_id',
        'host_id',
        'school',
        'period',
        'degree',
        'department',
    ];
}
