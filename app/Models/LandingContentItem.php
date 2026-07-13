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

    public function listItems(): array
    {
        $body = trim((string) ($this->body ?? ''));
        if ($body === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $body))));
    }
}
