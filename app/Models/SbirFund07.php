<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund07 extends Model
{
    use HasFactory;

    protected $table = 'sbir_fund07';

    protected $fillable = [
        'project_id',
        'user_id',
        'name',
        'code',
        'unit_price',
        'count',
        'total',
    ];
}
