<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryCategory extends Model
{
    use HasFactory;
    protected $table = "industrycategory";
    protected $fillable = ['name','description','carbon_annual_avg'
                          ,'carbon_source','carbon_measurement_method'
                          ,'carbon_last_updated'];

}
