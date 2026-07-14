<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'resume.uploaded' => \App\Http\Middleware\EnsureResumeUploaded::class,
        ]);

        // Runs on every web request (guests pass through untouched); logs
        // out any authenticated user whose account has been suspended.
        $middleware->web(append: [
            \App\Http\Middleware\CheckSuspendedUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();