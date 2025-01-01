<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureAvoid extends Model
{
    use HasFactory;
    protected $table = 'manufacture_avoid';
    protected $fillable = [
        'user_id', 'project_id', 'department', 'job', 'name'
    ];
}
