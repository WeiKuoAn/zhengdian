<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureExpected extends Model
{
    use HasFactory;
    protected $table = 'manufacture_expected';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'brand', 'model', 
        'purpose', 'cost', 'procurement', 'origin'
    ];
}
