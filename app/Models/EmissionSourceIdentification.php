<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionSourceIdentification extends Model
{
    use HasFactory;
    protected $table = "03_emission_source_identification";
    protected $fillable = ['stage_id','activity_data_file_path','photo_collection'];
}
