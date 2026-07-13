<?php

namespace App\Http\Controllers;

use App\Services\LandingPageService;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function show(LandingPageService $landingPageService): View
    {
        return view('landing.show', $landingPageService->buildPageData());
    }
}
