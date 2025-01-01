<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessEmission extends Model
{
    use HasFactory;
    protected $table = "process_emission_item";
    protected $fillable = ['process_code','process_emission_id','equipment_code','fuel_name'
                          ,'emission_data','activity_data','unit','ghg_type'
                          ,'single_source_emission_total','single_source_percentage'];
}
