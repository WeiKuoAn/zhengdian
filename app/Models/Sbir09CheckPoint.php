<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir09CheckPoint extends Model
{
    use HasFactory;
    protected $table = 'sbir09_check_point';

    protected $fillable = [
        'user_id',
        'project_id',
        'checkpoint_code',
        'checkpoint_due',
        'checkpoint_content',
    ];
}
