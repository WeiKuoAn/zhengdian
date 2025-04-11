<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbir04MainProduct extends Model
{
    use HasFactory;
    protected $table = 'sbir04_main_product';

    protected $fillable = [
        'user_id',
        'project_id',
        'product_name',
        'output_y1',
        'sales_y1',
        'share_y1',
        'output_y2',
        'sales_y2',
        'share_y2',
        'output_y3',
        'sales_y3',
        'share_y3',
    ];
}
