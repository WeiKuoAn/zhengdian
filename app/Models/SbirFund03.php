<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund03 extends Model
{
    use HasFactory;
    protected $table = 'sbir_fund03';

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
