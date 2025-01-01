<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordPlan extends Model
{
    use HasFactory;
    protected $table = "word_plan";
    protected $fillable = ['user_id','project_id','name','description','reduction_item','method'];
}
