<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = "branches";

    protected $fillable = [
        'customer_id','name','name','contact_name','contact_phone','contact_email','address','note'
    ];
}
