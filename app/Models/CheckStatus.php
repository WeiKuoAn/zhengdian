<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckStatus extends Model
{
    protected $table = 'check_status';
    protected $fillable = [
        'name', 'status','seq'
    ];
}
