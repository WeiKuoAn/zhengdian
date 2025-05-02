<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir09Point extends Model
{
    use HasFactory;
    protected $table = 'sbir09_point';

    protected $fillable = [
        'user_id',
        'project_id',
        'item',
        'weight',
        'month',
    ];
}
