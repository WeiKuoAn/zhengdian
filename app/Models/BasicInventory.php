<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;

class BasicInventory extends Model
{
    use HasFactory;

    protected $table = 'basic_inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'customer_id',
        'branch_id',
        'reason',
        'norm',
        'ipcc_id',
        'verification_agency',
        'status',
        'substantive',
        'significance',
        'exclusion',
        'base_year',
    ];

    public function cust_data()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function branch_data()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function reason_data()
    {
        $reason_type = ['0'=>'自主盤查','1'=>'依法申報','2'=>'其他'];
        return $reason_type[$this->reason];
    }

    public function status()
    {
        $status_type = ['0'=>'準備中','1'=>'盤查中','2'=>'驗證中','3'=>'已完成'];
        return $status_type[$this->status];
    }
}
