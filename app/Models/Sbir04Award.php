<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbir04Award extends Model
{
    use HasFactory;
    protected $table = 'sbir04_award';

    protected $fillable = [
        'user_id',
        'project_id',
        'award_year',
        'award_name',
    ];
}
