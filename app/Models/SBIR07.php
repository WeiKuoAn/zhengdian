<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SBIR07 extends Model
{
    use HasFactory;
    protected $table = 'sbir_07';
    protected $fillable = [
        'user_id',
        'project_id',
        'text1',
        'text2',
    ];
}
