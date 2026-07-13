<?php

namespace App\Http\Controllers;

use App\Models\LandingSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingSettingController extends Controller
{
    protected function ensureCanManageLanding(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法管理官網內容');
        }
    }

    public function edit(): View
    {
        $this->ensureCanManageLanding();
        $settings = LandingSetting::allCached();

        return view('landing_admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $this->ensureCanManageLanding();

        $keys = [
            'meta_title', 'meta_description',
            'hero_eyebrow', 'hero_title', 'hero_tagline', 'hero_lead', 'hero_btn_primary', 'hero_btn_secondary',
            'services_eyebrow', 'services_title', 'services_subtitle',
            'workflow_eyebrow', 'workflow_title', 'workflow_subtitle', 'workflow_footer',
            'themes_eyebrow', 'themes_title', 'themes_subtitle',
            'scenarios_eyebrow', 'scenarios_title', 'scenarios_subtitle',
            'cases_eyebrow', 'cases_title', 'cases_subtitle', 'cases_disclaimer',
            'academic_eyebrow', 'academic_title', 'academic_subtitle', 'academic_note',
            'why_eyebrow', 'why_title', 'why_subtitle',
            'cta_title', 'cta_text',
            'contact_name', 'contact_phone', 'contact_tel', 'contact_email', 'contact_line_url',
            'footer_desc',
        ];

        $pairs = [];
        foreach ($keys as $key) {
            $pairs[$key] = (string) $request->input($key, '');
        }

        LandingSetting::setMany($pairs);

        return redirect()->route('landing.settings')->with('success', '官網基本內容已更新');
    }
}
