<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund06 extends Model
{
    use HasFactory;

    protected $table = 'sbir_fund06';

    protected $fillable = [
        'project_id',
        'name',
        'code',
        'price',
        'count',
        'life',
        'monthly',
        'investment_months',
        'total',
    ];
}
