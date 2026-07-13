<?php

namespace App\Support;

class LandingSectionRegistry
{
    /** @return array<string, array<string, mixed>> */
    public static function sections(): array
    {
        return [
            'seo' => [
                'label' => '搜尋設定',
                'icon' => 'mdi-search-web',
                'hint' => 'Google 搜尋結果顯示的標題與描述',
                'anchor' => null,
                'settings' => ['meta_title', 'meta_description'],
                'content_types' => [],
            ],
            'hero' => [
                'label' => '首頁主視覺',
                'icon' => 'mdi-image-filter-hdr',
                'hint' => '訪客一進官網看到的主標題、說明與按鈕',
                'anchor' => '#hero',
                'settings' => [
                    'hero_eyebrow', 'hero_tagline', 'hero_title', 'hero_lead',
                    'hero_btn_primary', 'hero_btn_secondary',
                ],
                'content_types' => [],
            ],
            'stats' => [
                'label' => '數據統計',
                'icon' => 'mdi-counter',
                'hint' => '首頁四格數字（250+、6 億…）',
                'anchor' => null,
                'settings' => [],
                'content_types' => ['stat'],
            ],
            'services' => [
                'label' => '服務架構',
                'icon' => 'mdi-view-grid',
                'hint' => '四宮格服務介紹',
                'anchor' => '#services',
                'settings_prefix' => 'services',
                'content_types' => ['service'],
            ],
            'workflow' => [
                'label' => '補助流程',
                'icon' => 'mdi-timeline-clock',
                'hint' => '六步驟補助流程',
                'anchor' => '#workflow',
                'settings_prefix' => 'workflow',
                'extra_settings' => ['workflow_footer'],
                'content_types' => ['process'],
            ],
            'themes' => [
                'label' => '補助主題',
                'icon' => 'mdi-lightbulb-on',
                'hint' => '三張補助主題卡片',
                'anchor' => null,
                'settings_prefix' => 'themes',
                'content_types' => ['theme'],
            ],
            'scenarios' => [
                'label' => '服務場景',
                'icon' => 'mdi-account-group',
                'hint' => '三種服務情境說明',
                'anchor' => null,
                'settings_prefix' => 'scenarios',
                'content_types' => ['scenario'],
            ],
            'cases' => [
                'label' => '產業案例',
                'icon' => 'mdi-domain',
                'hint' => 'Brand Wall 區塊標題與說明文字',
                'anchor' => '#cases',
                'settings_prefix' => 'cases',
                'extra_settings' => ['cases_disclaimer'],
                'content_types' => [],
            ],
            'academic' => [
                'label' => '國際資源',
                'icon' => 'mdi-earth',
                'hint' => '產學統計、合作院校、學生來源國',
                'anchor' => '#academic',
                'settings_prefix' => 'academic',
                'extra_settings' => ['academic_note'],
                'content_types' => ['academic_stat', 'university', 'country'],
            ],
            'why' => [
                'label' => '為什麼選錚典',
                'icon' => 'mdi-star-circle',
                'hint' => '四大優勢說明',
                'anchor' => null,
                'settings_prefix' => 'why',
                'content_types' => ['why'],
            ],
            'contact' => [
                'label' => '聯絡與頁尾',
                'icon' => 'mdi-card-account-phone',
                'hint' => '聯絡我們區塊與頁尾資訊',
                'anchor' => '#contact',
                'settings' => [
                    'cta_title', 'cta_text',
                    'contact_name', 'contact_phone', 'contact_tel',
                    'contact_email', 'contact_line_url', 'footer_desc',
                ],
                'content_types' => [],
            ],
        ];
    }

    public static function sectionKeys(): array
    {
        return array_keys(self::sections());
    }

    public static function get(string $key): ?array
    {
        return self::sections()[$key] ?? null;
    }

    public static function resolve(string $key): array
    {
        $section = self::get($key);
        if ($section === null) {
            abort(404);
        }

        return $section;
    }

    public static function defaultKey(): string
    {
        return 'hero';
    }

    public static function normalizeKey(?string $key): string
    {
        $key = (string) $key;
        if ($key !== '' && array_key_exists($key, self::sections())) {
            return $key;
        }

        return self::defaultKey();
    }

    /** @return string[] */
    public static function settingKeysFor(string $sectionKey): array
    {
        $section = self::resolve($sectionKey);
        $keys = $section['settings'] ?? [];

        if (! empty($section['settings_prefix'])) {
            $prefix = (string) $section['settings_prefix'];
            $keys = array_merge($keys, [
                $prefix . '_eyebrow',
                $prefix . '_title',
                $prefix . '_subtitle',
            ]);
        }

        if (! empty($section['extra_settings'])) {
            $keys = array_merge($keys, $section['extra_settings']);
        }

        return array_values(array_unique($keys));
    }

    public static function sectionForContentType(string $type): string
    {
        foreach (self::sections() as $key => $section) {
            if (in_array($type, $section['content_types'] ?? [], true)) {
                return $key;
            }
        }

        return 'stats';
    }
}
