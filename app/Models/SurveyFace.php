<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyFace extends Model
{
    use HasFactory;
    protected $table = "surveys_face";
    protected $fillable = ['survey_id','name','description'];
}
