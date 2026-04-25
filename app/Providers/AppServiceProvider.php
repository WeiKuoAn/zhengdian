<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // URL::forceRootUrl(config('app.url'));   // 用 .env 的 APP_URL
        // URL::forceScheme('https');              // 一律用 HTTPS
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');
    }
}
