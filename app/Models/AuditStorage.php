<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditStorage extends Model
{
    use HasFactory;
    protected $table = "05_audit_storage";
    protected $fillable = ['stage_id','internal_verification','ares_international_certification_iso14064_1'
                          ,'ares_international_certification_zero_carbon','un_carbon_certificate','inventory_checklist'];
}
