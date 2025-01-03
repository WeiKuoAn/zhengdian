<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckStatus extends Model
{
    protected $table = 'check_status';
    protected $fillable = [
        'parent_id',
        'name',
        'status',
        'seq'
    ];

    public function check_data()
    {
        return $this->hasOne('App\Models\CheckStatus', 'id', 'parent_id');
    }
}
