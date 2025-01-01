<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SurveyFace;

class SurveyQuestion extends Model
{
    use HasFactory;
    protected $table = "survey_questions";
    protected $fillable = ['survey_id','face_id','type','options','scores','no','title'];

    public function face_data()
    {
        $data = SurveyFace::where('survey_id',$this->survey_id)->where('id',$this->face_id)->first();
        if ($data) {
            return $data->name;
        } 
        
    }
}
