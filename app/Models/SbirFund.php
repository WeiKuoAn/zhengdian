<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund extends Model
{
    use HasFactory;
    protected $table = 'sbir_fund';

    protected $fillable = [
        'user_id',
        'project_id',
        'subsidy_1_1',
        'self_1_1',
        'total_1_1',

        'subsidy_1_2',
        'self_1_2',
        'total_1_2',

        'subsidy_1_3',
        'self_1_3',
        'total_1_3',

        'subsidy_2_1',
        'self_2_1',
        'total_2_1',

        'subsidy_3_1',
        'self_3_1',
        'total_3_1',

        'subsidy_3_2',
        'self_3_2',
        'total_3_2',

        'subsidy_4_1',
        'self_4_1',
        'total_4_1',

        'subsidy_5_1',
        'self_5_1',
        'total_5_1',

        'subsidy_5_2',
        'self_5_2',
        'total_5_2',

        'subsidy_5_3',
        'self_5_3',
        'total_5_3',

        'subsidy_5_4',
        'self_5_4',
        'total_5_4',

        'subsidy_5_5',
        'self_5_5',
        'total_5_5',
        
        'subsidy_6_1',
        'self_6_1',
        'total_6_1',

        'total_subsidy',
        'total_self',
        'total_all',
    ];
}