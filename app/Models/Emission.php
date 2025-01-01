<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emission extends Model
{
    use HasFactory;

    protected $table = "emission";

    protected $fillable = [
        'basic_inventory_id',
        'scope_id',
        'source_id',
        'iso16064_id',
        'ghg_id',
        'process_id',
        'device_id',
        'electricity_type',
        'electricity_source',
        'fuel',
        'text',
        'image',
        'status',
    ];

    public function device_data()
    {
        return $this->hasOne('App\Models\Device', 'id', 'device_id');
    }

    public function process_data()
    {
        return $this->hasOne('App\Models\process', 'id', 'process_id');
    }

    public function source_data()
    {
        return $this->hasOne('App\Models\source', 'id', 'source_id');
    }

    public function iso14064_data()
    {
        return $this->hasOne('App\Models\Iso14064', 'id', 'iso16064_id');
    }

    public function ghg_data()
    {
        return $this->hasOne('App\Models\GhgProtocol', 'id', 'ghg_id');
    }

    public function emission_data()
    {
        return $this->hasOne('App\Models\EmissionData', 'emission_id', 'id');
    }

}
