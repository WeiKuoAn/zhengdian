<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbir04Shareholders extends Model
{
    use HasFactory;
    protected $table = 'sbir04_shareholders';

    protected $fillable = [
        'user_id',
        'project_id',
        'shareholder_name',
        'shareholder_amount',
        'shareholder_ratio',
        'shareholder_source',
    ];
}
