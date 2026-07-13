<?php

namespace App\Services;

use App\Models\LandingContentItem;
use App\Models\LandingIndustryCategory;
use App\Models\LandingSetting;

class LandingPageService
{
    public function buildPageData(): array
    {
        $settings = LandingSetting::allCached();

        $contentByType = LandingContentItem::query()
            ->where('status', 'up')
            ->orderBy('seq')
            ->orderBy('id')
            ->get()
            ->groupBy('type');

        $categories = LandingIndustryCategory::query()
            ->where('status', 'up')
            ->with(['activeBrandClients'])
            ->orderBy('seq')
            ->orderBy('id')
            ->get();

        return [
            'settings' => $settings,
            'stats' => $contentByType->get('stat', collect()),
            'services' => $contentByType->get('service', collect()),
            'processes' => $contentByType->get('process', collect()),
            'themes' => $contentByType->get('theme', collect()),
            'scenarios' => $contentByType->get('scenario', collect()),
            'whyCards' => $contentByType->get('why', collect()),
            'academicStats' => $contentByType->get('academic_stat', collect()),
            'countries' => $contentByType->get('country', collect()),
            'universities' => $contentByType->get('university', collect()),
            'categories' => $categories,
        ];
    }

    public function setting(string $key, string $default = ''): string
    {
        return LandingSetting::getValue($key, $default);
    }
}
