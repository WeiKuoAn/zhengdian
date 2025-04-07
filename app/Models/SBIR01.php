<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SBIR01 extends Model
{
    use HasFactory;
    protected $table = 'sbir_01'; // 或你資料庫實際存在的資料表名稱

    protected $fillable = [
        'plan_name',
        'project_id',
        'attribute',
        'stage',
        'domain',
        'feature',
        'target',
        'start_date',
        'end_date',
    ];
}
