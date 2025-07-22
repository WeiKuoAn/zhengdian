<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $table = "supplements";

    protected $fillable = [
        'project_id',
        'date',
        'question',
        'answer',
        'note',
        'is_urgent',
        'is_confirmed',
        'confirmed_at',
        'status',
    ];

}
