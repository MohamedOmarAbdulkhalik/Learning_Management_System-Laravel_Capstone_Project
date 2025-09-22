<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
->withExceptions(function (Exceptions $exceptions): void {
    // تسجيل الأخطاء في ملف logs
    $exceptions->report(function (Throwable $e) {
        Log::channel('exceptions')->error($e->getMessage(), [
            'exception' => get_class($e),
            'file'      => $e->getFile() . ':' . $e->getLine(),
            'url'       => request()->fullUrl(),
        ]);
    });

    // صفحة خطأ ودّية بدل رسالة Laravel الافتراضية
    $exceptions->render(function (Throwable $e, $request) {
        if (!config('app.debug')) {
            return response()->view('errors.500', [], 500);
        }
    });
})
->create();
