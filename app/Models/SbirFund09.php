<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund09 extends Model
{
    use HasFactory;

    protected $table = 'sbir_fund09';

    protected $fillable = [
        'project_id',
        'user_id',
        'tax_id',
        'company_name',
        'content',
        'total',
    ];
}
