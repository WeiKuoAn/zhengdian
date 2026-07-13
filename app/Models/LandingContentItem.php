<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingContentItem extends Model
{
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'body',
        'icon',
        'extra',
        'seq',
        'status',
    ];

    public static function typeLabels(): array
    {
        return [
            'stat' => '數據統計',
            'service' => '服務架構',
            'process' => '補助流程',
            'theme' => '補助主題',
            'scenario' => '服務場景',
            'why' => '為什麼選擇錚典',
            'academic_stat' => '產學統計',
            'university' => '合作院校',
            'country' => '學生來源國家',
        ];
    }

    public static function typeHints(): array
    {
        return [
            'stat' => '首頁四格數字（如 250+、6 億）',
            'service' => '服務架構區塊內的服務卡片',
            'process' => '補助流程的六個步驟',
            'theme' => '補助主題的三張卡片',
            'scenario' => '服務場景的三種情境',
            'why' => '為什麼選擇錚典的四項優勢',
            'academic_stat' => '國際資源區的四格統計',
            'university' => '合作院校名稱列表',
            'country' => '學生來源國家標籤',
        ];
    }

    public static function typeGroups(): array
    {
        return [
            '首頁' => ['stat'],
            '服務介紹' => ['service', 'process', 'theme', 'scenario', 'why'],
            '國際資源' => ['academic_stat', 'university', 'country'],
        ];
    }

    public function listItems(): array
    {
        $body = trim((string) ($this->body ?? ''));
        if ($body === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $body))));
    }
}
