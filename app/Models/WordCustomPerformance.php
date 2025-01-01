<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordCustomPerformance extends Model
{
    use HasFactory;
    protected $table = "word_custom_performance";
    protected $fillable = ['user_id','project_id','performance','before_guidance','after_guidance','explanation'];
}
