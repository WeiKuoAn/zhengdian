<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbir04ThreeYear extends Model
{
    use HasFactory;
    protected $table = 'sbir04_three_year';

    protected $fillable = [
        'user_id',
        'project_id',
        'year',
        'revenue',
        'rnd_cost',
        'ratio',
        'note',
    ];
}
