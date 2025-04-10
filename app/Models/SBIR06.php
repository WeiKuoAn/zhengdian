<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SBIR06 extends Model
{
    use HasFactory;
    protected $table = 'sbir_06';
    protected $fillable = [
        'user_id',
        'project_id',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5',
        'text6',
    ];
}
