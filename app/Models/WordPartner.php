<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordPartner extends Model
{
    use HasFactory;
    protected $table = 'word_partner';
    protected $fillable = [
        'user_id', 'project_id', 'name', 'job_content'
    ];
}
