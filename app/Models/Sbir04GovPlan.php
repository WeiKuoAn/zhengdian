<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbir04GovPlan extends Model
{
    use HasFactory;
    protected $table = 'sbir04_gov_plan';

    protected $fillable = [
        'user_id',
        'project_id',
        'plan_type',
        'plan_name',
        'start_date',
        'end_date',
        'gov_subsidy',
        'self_funding',
        'man_month',
        'expected_value',
        'expected_patent',
        'expected_employment',
        'expected_invest',
        'actual_value',
        'actual_patent',
        'actual_employment',
        'actual_invest',
        'plan_focus',
    ];
}
