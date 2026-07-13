<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingAdminController extends Controller
{
    public function index(): View
    {
        if (! in_array((int) (Auth::user()->level ?? 2), [0, 1], true)) {
            abort(403, '僅管理者可管理官網內容');
        }

        return view('landing_admin.dashboard');
    }
}
