<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureIso extends Model
{
    use HasFactory;
    protected $table = 'manufacture_iso';
    protected $fillable = [
        'user_id', 'project_id', 'name' , 'year' , 'status'
    ];
}
