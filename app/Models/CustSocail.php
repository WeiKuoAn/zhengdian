<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustSocail extends Model
{
    use HasFactory;
    protected $table = 'cust_socail';
    protected $fillable = [
        'user_id', 'project_id', 'type', 'context'
    ];
}
