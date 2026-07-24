<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exceptions\ApiException;
use App\Helpers\ApiResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (ApiException $e, Request $request) {
            return ApiResponse::error(
                $e->getMessage(),
                $e->getStatusCode(),
                $e->getErrors()
            );
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            return ApiResponse::error(
                Str::headline(class_basename($e->getModel())) . ' not found.',
                404
            );
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return ApiResponse::error(
                'Validation failed.',
                422,
                $e->errors()
            );
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return ApiResponse::error(
                'Unauthenticated.',
                401
            );
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return ApiResponse::error(
                $e->getMessage() ?: 'Unauthorized.',
                403
            );
        });


        $exceptions->render(function (QueryException $e, Request $request) {
            if (config('app.debug')) {
                return ApiResponse::error(
                    $e->getMessage(),
                    500
                );
            }

            return ApiResponse::error(
                'Database error occurred.',
                500
            );
        });


        $exceptions->render(function (Throwable $e, Request $request) {
            if (config('app.debug')) {
                return ApiResponse::error(
                    $e->getMessage(),
                    500
                );
            }

            return ApiResponse::error(
                'Something went wrong.',
                500
            );
        });
    })

    ->create();
