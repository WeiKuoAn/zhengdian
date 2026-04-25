<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware as MiddlewareConfigurator;
use App\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(
    basePath: dirname(__DIR__)
)
->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (MiddlewareConfigurator $middleware) {
    // 把 TrustProxies 放到全域 middleware 的最前面
    // $middleware->prepend(TrustProxies::class);
})
->withExceptions(function (Exceptions $exceptions) {
    //
})
->create();
