<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessNeed extends Model
{
    use HasFactory;
    protected $table = 'business_need';
    protected $fillable = [
        'user_id', 'project_id', 'name' , 'context'
    ];
}
