<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable = [
        'name', 'industry_id', 'primary_contact_name', 'primary_contact_phone', 
        'primary_contact_email', 'contact_job', 'address', 'business_registration_no',
        'established_date', 'operational_status', 'company_scale', 'stock_status',
        'sales_orientation', 'sales_region', 'permission_status', 'note', 'county', 'district',
    ];

    public function cust_data()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function industry_category_data()
    {
        return $this->hasOne('App\Models\IndustryCategory', 'id', 'industry_id');
    }
    
    public function cust_project()
    {
        return $this->hasOne('App\Models\CustProject', 'user_id', 'user_id');
    }

    public function company_scale()
    {
        $company_scale_type = ['0'=>'10人以下', '1'=>'10人已上' ,'2'=>'50人以上、100以下', '3'=>'100人以上'];
        return $company_scale_type[$this->company_scale];
    }

    public function stock_status()
    {
        $stock_status_type = ['0'=>'未上櫃,有以IPO為目標' , '1'=>'未上櫃,未來也無意上櫃' , '2'=>'已上市/已上櫃'];
        return $stock_status_type[$this->stock_status];
    }

    public function sales_orientation()
    {
        $sales_orientation_type = ['0'=>'B2B' , '1'=>'B2C' , '2'=>'B2G'];
        return $sales_orientation_type[$this->sales_orientation];
    }
}
