<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SBIR05 extends Model
{
    use HasFactory;
    protected $table = 'sbir_05';
    protected $fillable = [
        'user_id',
        'project_id',
        'text1',
        'text2',
        'text3',
    ];
}
