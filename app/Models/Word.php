<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    protected $table = "word";
    protected $fillable = ['user_id','project_id','introduction','mobile','fax','principal_job','principal_sex'
                           ,'startup','business_activities','industry_category','create_date','website','project_name'
                           ,'project_start','project_end','total','subsidy','self_funding','project_summary','partner'
                           ,'face','growth_face','organization_relationship','application_solution','checkpoint','capital_amount','color'];
}
