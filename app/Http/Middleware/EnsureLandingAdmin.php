<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureLandingAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $level = (int) (Auth::user()->level ?? 2);

        if (! in_array($level, [0, 1], true)) {
            abort(403, '僅管理者可管理官網內容');
        }

        return $next($request);
    }
}
