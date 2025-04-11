<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbir04Applyingplan extends Model
{
    use HasFactory;
    protected $table = 'sbir04_applyingplan';

    protected $fillable = [
        'user_id',
        'project_id',
        'apply_date',
        'apply_org',
        'apply_name',
        'apply_start',
        'apply_end',
        'apply_grant',
        'apply_self',
    ];
}
