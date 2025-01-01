<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionData extends Model
{
    use HasFactory;

    protected $table = "emission_data";

    protected $fillable = ['emission_id', 'value_type', 'value', 'unit', 'emission_value'];

}
