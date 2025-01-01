<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordBenefit extends Model
{
    use HasFactory;
    protected $table = "word_benefit";
    protected $fillable = ['user_id','project_id','item','benefit'];
}
