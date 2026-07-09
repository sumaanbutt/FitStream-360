<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

abstract class Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        $controllerClass = class_basename(static::class);
        $currentMethod = request()->route()?->getActionMethod();

        $excludedControllers = [
            'AuthenticatedSessionController',
            'RegisteredUserController',
            'PasswordResetLinkController',
            'NewPasswordController',
            'ConfirmablePasswordController',
            'EmailVerificationNotificationController',
            'VerifyEmailController',
        ];

        if (in_array($controllerClass, $excludedControllers)) {
            return [];
        }

        $resource = Str::lower(Str::replaceLast('Controller', '', $controllerClass));

        $actionMap = [
            'index'   => 'viewAny',
            'show'    => 'view',
            'store'   => 'create',
            'update'  => 'update',
            'destroy' => 'delete',
            ];

        if ($currentMethod && array_key_exists($currentMethod, $actionMap)) {
            $permissionRequired = "{$resource}.{$actionMap[$currentMethod]}";

            return [
                new Middleware(function ($request, $next) use ($permissionRequired) {
                    Gate::authorize($permissionRequired);

                    return $next($request);
                })
            ];
        }

        return [];
    }
}
