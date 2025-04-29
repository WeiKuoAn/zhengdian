<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund13 extends Model
{
    use HasFactory;
    protected $table = 'sbir_fund13';
    protected $fillable = [
        'project_id',
        'purpose',
        'location',
        'days',
        'people',
        'airfare',
        'transport',
        'accommodation',
        'meals',
        'others',
        'total',
    ];
}
