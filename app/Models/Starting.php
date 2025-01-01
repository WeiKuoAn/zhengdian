<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starting extends Model
{
    use HasFactory;
    protected $table = "01_starting";
    protected $fillable = ['stage_id','meeting_file_path','commitment_date','organization_file_path'];
}
