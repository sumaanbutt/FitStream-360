<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Attributes\Permission;
use Illuminate\Support\Facades\Route;
use ReflectionMethod;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Route::matched(function ($routeMatched) {
            $action = $routeMatched->route->getAction('controller');

            if ($action && is_string($action) && str_contains($action, '@')) {
                [$controllerClass, $method] = explode('@', $action);

                try {
                    // 1. Inspect the targeted controller class method using pure PHP Reflection
                    $reflection = new ReflectionMethod($controllerClass, $method);
                    $hasAttribute = ! empty($reflection->getAttributes(Permission::class));

                    if (! $hasAttribute) {
                        return;
                    }

                    $routeMatched->route->uses(function (...$parameters) use ($controllerClass, $method) {
                        $controllerInstance = app($controllerClass);
                        return Permission::watch($controllerInstance, $method, $parameters);
                    });

                } catch (\ReflectionException $e) {
                }
            }
        });
    }
}




