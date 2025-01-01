<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $table = "surveys";
    protected $fillable = ['category','title','description','start_date','end_date','status'];


    public function face_datas()
    {
        return $this->hasMany('App\Models\SurveyFace', 'survey_id', 'id');
    }

    public function response_data()
    {
        return $this->hasMany('App\Models\SurveyResponse', 'survey_id', 'id');
    }
}
