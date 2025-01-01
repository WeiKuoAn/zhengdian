<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    use HasFactory;

    protected $table = "scopes";

    protected $fillable = [
        'name'
    ];

    public function emission_datas()
    {
        return $this->hasMany('App\Models\Emission', 'scope_id', 'id');
    }
}
