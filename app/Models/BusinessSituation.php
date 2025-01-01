<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSituation extends Model
{
    use HasFactory;
    protected $table = 'business_situation';
    protected $fillable = [
        'user_id', 'project_id', 'context'
    ];
}
