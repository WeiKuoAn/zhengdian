<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustProject extends Model
{
    use HasFactory;
    protected $table = "cust_project";
    protected $fillable = ['user_id','year','type','status'];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function cust_data()
    {
        return $this->hasOne('App\Models\CustData', 'user_id', 'user_id');
    }

    public function personnel_datas()
    {
        return $this->hasMany('App\Models\ProjectPersonnel', 'project_id', 'id');
    }

    public function word_question_datas()
    {
        return $this->hasMany('App\Models\WordQuestion', 'project_id', 'id');
    }

    public function word_plan_datas()
    {
        return $this->hasMany('App\Models\WordPlan', 'project_id', 'id');
    }

    public function word_serve_datas()
    {
        return $this->hasMany('App\Models\WordServe', 'project_id', 'id');
    }

    public function word_check_datas()
    {
        return $this->hasMany('App\Models\WordCheck', 'project_id', 'id');
    }

    public function word_planned_datas()
    {
        return $this->hasMany('App\Models\WordPlanned', 'project_id', 'id');
    }

    public function fund_data()
    {
        return $this->hasOne('App\Models\WordFund', 'project_id', 'id');
    }

    public function word_effectiveness_datas()
    {
        return $this->hasMany('App\Models\WordEffectiveness', 'project_id', 'id');
    }

    public function word_reduction_item_datas()
    {
        return $this->hasMany('App\Models\WordReductionItem', 'project_id', 'id');
    }

    public function word_benefit_datas()
    {
        return $this->hasMany('App\Models\WordBenefit', 'project_id', 'id');
    }
    
    public function word_custom_datas()
    {
        return $this->hasMany('App\Models\WordCustomPerformance', 'project_id', 'id');
    }

    public function word_partner_datas()
    {
        return $this->hasMany('App\Models\WordPartner', 'project_id', 'id');
    }

    public function drive_datas()
    {
        return $this->hasMany('App\Models\BusinessDrive', 'project_id', 'id');
    }

    public function situation_datas()
    {
        return $this->hasMany('App\Models\BusinessSituation', 'project_id', 'id');
    }

    public function need_datas()
    {
        return $this->hasMany('App\Models\BusinessNeed', 'project_id', 'id');
    }

    public function manufacture_need_data()
    {
        return $this->hasone('App\Models\ManufactureNeed', 'project_id', 'id');
    }

    public function manufacture_expected_datas()
    {
        return $this->hasMany('App\Models\ManufactureExpected', 'project_id', 'id');
    }

    public function manufacture_improve_datas()
    {
        return $this->hasMany('App\Models\ManufactureImprove', 'project_id', 'id');
    }

    public function project_host()
    {
        return $this->hasOne('App\Models\ProjectHost', 'user_id', 'user_id');
    }
}
