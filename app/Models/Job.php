<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $table = "job";

    protected $fillable = [
        'id',
        'name',
        'status',
        'state',
        'director_id',
    ];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function director_data()
    {
        return $this->hasOne('App\Models\Job', 'id', 'director_id');
    }
}
