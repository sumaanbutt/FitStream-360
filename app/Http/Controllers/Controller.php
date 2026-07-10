<?php
//
//namespace App\Http\Controllers;
//
//use Illuminate\Routing\Controllers\HasMiddleware;
//use Illuminate\Routing\Controllers\Middleware;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\Str;
//
//abstract class Controller implements HasMiddleware
//{
//    public static function middleware(): array
//    {
//        $controllerClass = class_basename(static::class);
//        $currentMethod = request()->route()?->getActionMethod();
//
//        $excludedControllers = [
//            'AuthenticatedSessionController',
//            'RegisteredUserController',
//            'PasswordResetLinkController',
//            'NewPasswordController',
//            'ConfirmablePasswordController',
//            'EmailVerificationNotificationController',
//            'VerifyEmailController',
//        ];
//
//        if (in_array($controllerClass, $excludedControllers) || !$currentMethod) {
//            return [];
//        }
//
//        $resource = Str::lower(Str::replaceLast('Controller', '', $controllerClass));
//
//        $permissionRequired = "{$resource}.{$currentMethod}";
//
//        return [
//                new Middleware(function ($request, $next) use ($permissionRequired) {
//                    Gate::authorize($permissionRequired);
//
//                    return $next($request);
//                })
//            ];
//    }
//}
//namespace App\Http\Controllers;
//
//use Illuminate\Routing\Controllers\HasMiddleware;
//use Illuminate\Routing\Controllers\Middleware;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\Str;
//
//abstract class Controller implements HasMiddleware
//{
//    public static function middleware(): array
//    {
//        $controllerClass = class_basename(static::class);
//        $currentMethod = request()->route()?->getActionMethod();
//
//        $excludedControllers = [
//            'AuthenticatedSessionController',
//            'RegisteredUserController',
//            'PasswordResetLinkController',
//            'NewPasswordController',
//            'ConfirmablePasswordController',
//            'EmailVerificationNotificationController',
//            'VerifyEmailController',
//        ];
//
//        if (in_array($controllerClass, $excludedControllers) || !$currentMethod) {
//            return [];
//        }
//
//        $resource = Str::lower(Str::replaceLast('Controller', '', $controllerClass));
//        $cleanClassName = Str::replaceLast('Controller', '', $controllerClass);
//        $resource = Str::kebab($cleanClassName);
//
//        $laravelOverrides = [
//            'index' => 'viewAny',
//            'show' => 'view',
//            'store' => 'create',
//            'update' => 'update',
//            'destroy' => 'delete',
//        ];
//
//        $action = $laravelOverrides[$currentMethod] ?? $currentMethod;
//
//        $permissionRequired = "{$resource}.{$action}";
//
//        return [
//            new Middleware(function ($request, $next) use ($permissionRequired) {
//                Gate::authorize($permissionRequired);
//
//                return $next($request);
//            })
//        ];
//    }
//}
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

        if (in_array($controllerClass, $excludedControllers) || !$currentMethod) {
            return [];
        }

        $cleanClassName = Str::replaceLast('Controller', '', $controllerClass);
        $resource = Str::kebab($cleanClassName);

        $permissionRequired = "can-{$currentMethod}-{$resource}";

        return [
            new Middleware(function ($request, $next) use ($permissionRequired) {
                Gate::authorize($permissionRequired);

                return $next($request);
            })
        ];
    }
}

//permission will pass in middleware in argument as an array then will check and authorize
