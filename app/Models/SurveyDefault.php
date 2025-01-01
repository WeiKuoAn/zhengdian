<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDefault extends Model
{
    use HasFactory;
    protected $table = "survey_default";
    protected $fillable = ['survey_id','score','reply','suggestion'];
}
