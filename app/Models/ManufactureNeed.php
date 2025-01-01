<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureNeed extends Model
{
    use HasFactory;
    protected $table = 'manufacture_need';
    protected $fillable = [
        'user_id', 'project_id', 'context'
    ];
}
