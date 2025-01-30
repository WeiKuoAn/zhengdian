<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarCategory extends Model
{
    use HasFactory;

    protected $table = "calendarcategory";

    protected $fillable = [
        'name','classname','status','seq'
    ];
}
