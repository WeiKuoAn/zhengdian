<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordServe extends Model
{
    use HasFactory;
    protected $table = "word_serve";
    protected $fillable = ['user_id','project_id','item','context'];
}
