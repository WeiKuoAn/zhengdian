<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund04 extends Model
{
    use HasFactory;
    protected $table = 'sbir_fund04';
    protected $fillable = [
        'project_id',
        'user_id',
        'name',
        'unit',
        'quantity',
        'price',
        'total',
    ];
}
