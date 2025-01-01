<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemCalculation extends Model
{
    use HasFactory;
    protected $table = "04_system_calculation";
    protected $fillable = ['stage_id','emission_inventory_file_path','verification_unit_review','verification_unit_review_date'];
}
