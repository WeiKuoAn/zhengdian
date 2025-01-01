<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoundarySetting extends Model
{
    use HasFactory;
    protected $table = "02_boundary_setting";
    protected $fillable = ['stage_id','standard','organizational_boundary_setting'
                          ,'boundary_setting','boundary_address','reference_year'];
}
