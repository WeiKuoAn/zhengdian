<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonReduction extends Model
{
    use HasFactory;

    protected $table = 'carbon_reduction';

    protected $fillable = [
        'customer_id',
        'target',
        'deadline',
        'budget',
        'measure_name',
        'description',
        'estimated_cost',
        'implementation',
        'progress_status',
    ];

    public function status()
    {
        $type = ['0'=>'準備中','1'=>'執行中','2'=>'完成'];
        return $type[$this->progress_status];
    }

    public function measure()
    {
        $type = [
            '0' => '開始碳減排計劃',
            '1' => '能源效率改進',
            '2' => '可再生能源',
            '3' => '供應鏈優化',
            '4' => '廢物減量和回收',
            '5' => '員工教育和參與',
            '6' => '碳抵消',
            '7' => '遠程工作和虛擬會議',
            '8' => '綠色建築',
            '9' => '碳盤查和報告'
        ];
        return $type[$this->measure_name];
    }
}
