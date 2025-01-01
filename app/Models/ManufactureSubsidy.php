<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureSubsidy extends Model
{
    use HasFactory;
    protected $table = 'manufacture_subsidy';
    protected $fillable = [
        'user_id', 'project_id', 'name' , 'year'
    ];
}
