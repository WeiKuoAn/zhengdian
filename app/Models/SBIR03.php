<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SBIR03 extends Model
{
    use HasFactory;
    protected $table = 'sbir_03';

    protected $fillable = [
        'plan_summary',
        'innovation_focus',
        'execution_advantage',
        'benefit_output_value',
        'benefit_new_products',
        'benefit_derived_products',
        'benefit_rnd_cost',
        'benefit_investment',
        'benefit_cost_reduction',
        'benefit_jobs_created',
        'benefit_new_companies',
        'benefit_patents',
        'benefit_new_patents',
        'project_id',
        'user_id',
    ];
}
