<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAppendix extends Model
{
    use HasFactory;
    protected $table = "project_appendix";
    protected $fillable = ['project_id','checkboxes_status'];
    protected $casts = [
        'checkboxes_status' => 'array', // 自動將 JSON 字串轉換為 PHP 陣列
    ];
}
