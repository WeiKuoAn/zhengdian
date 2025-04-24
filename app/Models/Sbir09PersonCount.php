<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbir09PersonCount extends Model
{
    use HasFactory;
    protected $table = 'sbir09_person_count';

    protected $fillable = [
        'user_id',
        'project_id',
        'count_phd',
        'count_master',
        'count_bachelor',
        'count_others',
        'count_male',
        'count_female',
        'count_pending',
    ];
}
