<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $table = "stages";
    protected $fillable = ['customer_id','branch_id','year','stage_number'];

    public function branch_data()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function customer_data()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function starting_data()
    {
        return $this->belongsTo('App\Models\Starting', 'id', 'stage_id');
    }

    public function boundary_setting_data()
    {
        return $this->belongsTo('App\Models\BoundarySetting', 'id', 'stage_id');
    }

    public function emission_source_identification_data()
    {
        return $this->belongsTo('App\Models\EmissionSourceIdentification', 'id', 'stage_id');
    }

    public function system_calculation_data()
    {
        return $this->belongsTo('App\Models\SystemCalculation', 'id', 'stage_id');
    }

    public function audit_storage_data()
    {
        return $this->belongsTo('App\Models\AuditStorage', 'id', 'stage_id');
    }

}
