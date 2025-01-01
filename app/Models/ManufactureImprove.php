<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureImprove extends Model
{
    use HasFactory;
    protected $table = 'manufacture_improve';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'focus', 'cost', 'delegate_object'
    ];
}
