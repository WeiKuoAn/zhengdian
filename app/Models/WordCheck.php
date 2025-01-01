<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordCheck extends Model
{
    use HasFactory;
    protected $table = "word_check";
    protected $fillable = ['user_id','project_id','item','estimated','unit'
                          ,'midterm_checkpoint','final_checkpoint','proportion','audit_data'];
}
