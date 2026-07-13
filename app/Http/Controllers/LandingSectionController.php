<?php

namespace App\Http\Controllers;

use App\Models\LandingContentItem;
use App\Models\LandingSetting;
use App\Support\LandingSectionRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingSectionController extends Controller
{
    protected function ensureCanManageLanding(): void
    {
        if (! in_array((int) (Auth::user()->level ?? 2), [0, 1], true)) {
            abort(403, '僅管理者可管理官網內容');
        }
    }

    public function show(Request $request): View
    {
        $this->ensureCanManageLanding();

        $sectionKey = LandingSectionRegistry::normalizeKey($request->input('section'));
        $section = LandingSectionRegistry::resolve($sectionKey);
        $settings = LandingSetting::allCached();

        $itemsByType = [];
        foreach ($section['content_types'] ?? [] as $type) {
            $itemsByType[$type] = LandingContentItem::query()
                ->where('type', $type)
                ->orderBy('seq')
                ->orderBy('id')
                ->get();
        }

        return view('landing_admin.sections.show', [
            'sections' => LandingSectionRegistry::sections(),
            'sectionKey' => $sectionKey,
            'section' => $section,
            'settings' => $settings,
            'itemsByType' => $itemsByType,
            'typeLabels' => LandingContentItem::typeLabels(),
            'typeHints' => LandingContentItem::typeHints(),
        ]);
    }

    public function update(Request $request, string $section): RedirectResponse
    {
        $this->ensureCanManageLanding();
        LandingSectionRegistry::resolve($section);

        $keys = LandingSectionRegistry::settingKeysFor($section);
        $pairs = [];
        foreach ($keys as $key) {
            $pairs[$key] = (string) $request->input($key, '');
        }

        if ($pairs !== []) {
            LandingSetting::setMany($pairs);
        }

        return redirect()
            ->route('landing.sections', ['section' => $section])
            ->with('success', '「' . (LandingSectionRegistry::get($section)['label'] ?? '') . '」已儲存');
    }
}
