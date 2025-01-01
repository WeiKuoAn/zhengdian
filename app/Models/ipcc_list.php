<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ipcc_list extends Model
{
    use HasFactory;
    protected $table = "ipcc_list";
    protected $fillable = ['ipcc_id','code','name','value'];
}
