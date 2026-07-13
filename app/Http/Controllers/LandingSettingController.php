<?php

namespace App\Http\Controllers;

use App\Support\LandingSectionRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function edit(Request $request): RedirectResponse
    {
        return redirect()->route('landing.sections', [
            'section' => LandingSectionRegistry::normalizeKey($request->input('section', 'seo')),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        return redirect()->route('landing.sections', ['section' => 'seo']);
    }
}
