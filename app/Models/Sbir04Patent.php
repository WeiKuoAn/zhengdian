<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir04Patent extends Model
{
    use HasFactory;
    protected $table = 'sbir04_patent';

    protected $fillable = [
        'user_id',
        'project_id',
        'patent_info',
        'patent_desc',
    ];
}
