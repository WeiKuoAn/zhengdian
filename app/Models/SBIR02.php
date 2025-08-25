<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SBIR02 extends Model
{
    use HasFactory;
    protected $table = 'sbir_02'; // 或你資料庫實際存在的資料表名稱

    protected $fillable = [
        'user_id',
        'project_id',
        'serve',
        'contact_zipcode',
        'contact_county',
        'contact_district',
        'contact_address',
        'rd_zipcode',
        'rd_address',
        'cust_introduce',
        'youth_startup',
        'government_support',
        'has_rnd',
        'context',
    ];
}
