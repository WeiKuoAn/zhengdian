<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustFactory extends Model
{
    use HasFactory;
    protected $table = 'cust_factory';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'zipcode', 'address','number','setting'
    ];
}
