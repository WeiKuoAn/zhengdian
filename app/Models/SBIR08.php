<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SBIR08 extends Model
{
    use HasFactory;
    protected $table = 'sbir_08';
    protected $fillable = [
        'user_id',
        'project_id',
        'text1',
    ];
}
