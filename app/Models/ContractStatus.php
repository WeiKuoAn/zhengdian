<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    protected $table = 'contract_status';
    protected $fillable = [
        'name', 'status','seq'
    ];

    
}
