<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustData extends Model
{
    use HasFactory;
    protected $table = 'cust_data';
    protected $fillable = [
        'user_id', 'year', 'type', 'last_year_revenue', 'insured_employees','introduce','capital','registration_no',
        'insurance_male', 'insurance_female', 'insurance_total','introduce' ,'production_chart', 'clients_market',
        'export_status', 'contact_name', 'contact_email', 'contact_phone','contact_jo','principal_name','limit_status',
        'nas_link', 'attached_link' , 'download_link' , 'carbon_done','principal_user_id', 'status','avoid','subsidy','carbon_iso',
        'county','district','zipcode','address','receive_email','receive_email_pwd',
        'factory_county','factory_district','factory_zipcode','factory_address','check_status','contract_status','id_card','birthday','create_date','update_date','profit_margin'
    ];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function cust_project()
    {
        return $this->hasMany('App\Models\CustProject', 'user_id', 'user_id');
    }
    

    public function user_projects()
    {
        return $this->hasMany('App\Models\CustProject', 'user_id', 'user_id')->where('status','0');
    }

    // public function cust_data()
    // {
    //     return $this->hasOne('App\Models\CustData', 'user_id', 'user_id');
    // }

    public function manufacture_avoid_data()
    {
        return $this->hasOne('App\Models\ManufactureAvoid', 'user_id', 'user_id');
    }

    public function manufacture_income_datas()
    {
        return $this->hasMany('App\Models\ManufactureThreeIncome', 'user_id', 'user_id');
    }

    public function manufacture_norm_datas()
    {
        return $this->hasMany('App\Models\ManufactureNorm', 'user_id', 'user_id');
    }

    public function socail_datas()
    {
        return $this->hasMany('App\Models\CustSocail', 'user_id', 'user_id');
    }

    public function manufacture_iso_datas()
    {
        return $this->hasMany('App\Models\ManufactureIso', 'user_id', 'user_id');
    }

    public function manufacture_subsidy_datas()
    {
        return $this->hasMany('App\Models\ManufactureSubsidy', 'user_id', 'user_id');
    }

    public function checkstatus()
    {
        return $this->hasOne('App\Models\CheckStatus', 'contract_status', 'id');
    }
}
