<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ipcc_report extends Model
{
    use HasFactory;
    protected $table = "ipcc_report";
    protected $fillable = ['year','name','quote'];
}
