<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordEffectiveness extends Model
{
    use HasFactory;
    protected $table = "word_effectiveness";
    protected $fillable = ['user_id','project_id','kpi','goal','definition'];
}
