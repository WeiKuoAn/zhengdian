<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordPlanned extends Model
{
    use HasFactory;
    protected $table = "word_planned";
    protected $fillable = ['user_id','project_id','item'];
}
