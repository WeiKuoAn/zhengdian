<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SBIRStaff extends Model
{
    use HasFactory;
    protected $table = 'sbir_staff';

    protected $fillable = [
        'user_id',
        'project_id',
        'staff_name',
        'staff_title',
        'account_category',
        'is_rnd',
        'education',
        'experience',
        'achievement',
        'seniority',
        'task',
    ];
}
