<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordReductionItem extends Model
{
    use HasFactory;
    protected $table = "word_reduction_item";
    protected $fillable = ['user_id','project_id','before_guidance','after_guidance','difference','relationship'];
}
