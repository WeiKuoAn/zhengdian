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

        'percentage_1',
        'percentage_2',
        'percentage_3',
        'percentage_4',
        'percentage_5',
        'percentage_6',
        'percentage_7',
        'percentage_8',
        'percentage_9',
        'percentage_10',
        'percentage_11',
        'percentage_12',
        'percentage_13',


        'subtotal_1_1',
        'subtotal_1_2',
        'subtotal_1_3',
        'subtotal_2_1',
        'subtotal_3_1',
        'subtotal_3_2',
        'subtotal_3_3',
        'subtotal_4_1',
        'subtotal_4_2',
        'subtotal_4_3',
        'subtotal_5_1',
        'subtotal_5_2',
        'subtotal_5_3',
        'subtotal_6_1',
        'subtotal_6_2',
        'subtotal_6_3',

    ];
}