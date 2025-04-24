<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund01 extends Model
{
    use HasFactory;
    protected $table = 'sbir_fund01';

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'title',
        'salary',
        'man_month',
        'total',
    ];
}
