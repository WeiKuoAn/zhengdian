<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureThreeIncome extends Model
{
    use HasFactory;
    protected $table = 'manufacture_three_income';
    protected $fillable = [
        'user_id', 'project_id', 'year' , 'income'
    ];
}
