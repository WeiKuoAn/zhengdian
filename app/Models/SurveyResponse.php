<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;
    protected $table = "survey_response";
    protected $fillable = ['survey_id','customer_id','answers_data','score'];

}
