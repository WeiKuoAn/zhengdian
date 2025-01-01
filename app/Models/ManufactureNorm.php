<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureNorm extends Model
{
    use HasFactory;
    protected $table = 'manufacture_norm';
    protected $fillable = [
        'user_id', 'project_id', 'name' , 'context'
    ];
}
