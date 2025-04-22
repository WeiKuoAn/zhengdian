<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir09HostPlan extends Model
{
    use HasFactory;
    protected $table = 'sbir09_host_plan';

    protected $fillable = [
        'user_id',
        'project_id',
        'host_id',
        'plan_name',
        'plan_period',
        'plan_company',
        'plan_duty',
    ];
}
