<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordQuestion extends Model
{
    use HasFactory;
    protected $table = "word_question";
    protected $fillable = ['user_id','project_id','question','solution','illustrate'];
}
