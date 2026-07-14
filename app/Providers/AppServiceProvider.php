<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Attributes\Permission;
use Illuminate\Support\Facades\Route;
use ReflectionMethod;
use Illuminate\Routing\Contracts\ControllerDispatcher;

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

        // 🌟 THE CLEAN FIX: Intercept the framework's native controller dispatcher
        $this->app->singleton(ControllerDispatcher::class, function ($app) {
            return new class($app) extends \Illuminate\Routing\ControllerDispatcher {

                public function dispatch(\Illuminate\Routing\Route $route, $controller, $method)
                {
                    try {
                        $reflection = new ReflectionMethod($controller, $method);
                        $attributes = $reflection->getAttributes(Permission::class);

                        if (!empty($attributes)) {

                            $user = auth()->user();

                            $attributes[0]->newInstance()->authorize($user);
                        }
                    } catch (\ReflectionException $e) {
                        abort(403, 'Authorization reflection error.');
                    }

                    return parent::dispatch($route, $controller, $method);
                }
            };
        });
    }
}

