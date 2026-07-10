<?php
////
////namespace App\Http\Controllers;
////
////use Illuminate\Routing\Controllers\HasMiddleware;
////use Illuminate\Routing\Controllers\Middleware;
////use Illuminate\Support\Facades\Gate;
////use Illuminate\Support\Str;
////
////abstract class Controller implements HasMiddleware
////{
////    public static function middleware(): array
////    {
////        $controllerClass = class_basename(static::class);
////        $currentMethod = request()->route()?->getActionMethod();
////
////        $excludedControllers = [
////            'AuthenticatedSessionController',
////            'RegisteredUserController',
////            'PasswordResetLinkController',
////            'NewPasswordController',
////            'ConfirmablePasswordController',
////            'EmailVerificationNotificationController',
////            'VerifyEmailController',
////        ];
////
////        if (in_array($controllerClass, $excludedControllers) || !$currentMethod) {
////            return [];
////        }
////
////        $resource = Str::lower(Str::replaceLast('Controller', '', $controllerClass));
////
////        $permissionRequired = "{$resource}.{$currentMethod}";
////
////        return [
////                new Middleware(function ($request, $next) use ($permissionRequired) {
////                    Gate::authorize($permissionRequired);
////
////                    return $next($request);
////                })
////            ];
////    }
////}
////namespace App\Http\Controllers;
////
////use Illuminate\Routing\Controllers\HasMiddleware;
////use Illuminate\Routing\Controllers\Middleware;
////use Illuminate\Support\Facades\Gate;
////use Illuminate\Support\Str;
////
////abstract class Controller implements HasMiddleware
////{
////    public static function middleware(): array
////    {
////        $controllerClass = class_basename(static::class);
////        $currentMethod = request()->route()?->getActionMethod();
////
////        $excludedControllers = [
////            'AuthenticatedSessionController',
////            'RegisteredUserController',
////            'PasswordResetLinkController',
////            'NewPasswordController',
////            'ConfirmablePasswordController',
////            'EmailVerificationNotificationController',
////            'VerifyEmailController',
////        ];
////
////        if (in_array($controllerClass, $excludedControllers) || !$currentMethod) {
////            return [];
////        }
////
////        $resource = Str::lower(Str::replaceLast('Controller', '', $controllerClass));
////        $cleanClassName = Str::replaceLast('Controller', '', $controllerClass);
////        $resource = Str::kebab($cleanClassName);
////
////        $laravelOverrides = [
////            'index' => 'viewAny',
////            'show' => 'view',
////            'store' => 'create',
////            'update' => 'update',
////            'destroy' => 'delete',
////        ];
////
////        $action = $laravelOverrides[$currentMethod] ?? $currentMethod;
////
////        $permissionRequired = "{$resource}.{$action}";
////
////        return [
////            new Middleware(function ($request, $next) use ($permissionRequired) {
////                Gate::authorize($permissionRequired);
////
////                return $next($request);
////            })
////        ];
////    }
////}
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
//        $cleanClassName = Str::replaceLast('Controller', '', $controllerClass);
//        $resource = Str::kebab($cleanClassName);
//
//        $permissionRequired = "can-{$currentMethod}-{$resource}";
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
use Illuminate\Support\Str;

abstract class Controller implements HasMiddleware
{
    /**
     * 🌟 A CENTRAL DICTIONARY: Map every resource controller class
     * to its explicit permission array strings.
     */
    protected static array $globalPermissionsMap = [
        'OrganizationController' => [
            'index' => ['can-view-organization'],
            'show' => ['can-view-organization'],
            'store' => ['can-create-organization'],
            'update' => ['can-update-organization', 'can-edit-global'], // Passing an array of arguments
            'destroy' => ['can-deactivate-organization'],
        ],
        'BusinessController' => [
            'index' => ['can-view-business'],
            'show' => ['can-view-business'],
            'store' => ['can-create-business'],
            'update' => ['can-update-business'],
            'destroy' => ['can-deactivate-business'],
        ],
    ];

    public static function middleware(): array
    {
        $controllerClass = class_basename(static::class);
        $middlewareSpecs = [];

        // Check if the current controller has an explicit permission map configured
        if (array_key_exists($controllerClass, self::$globalPermissionsMap)) {
            $methodsMap = self::$globalPermissionsMap[$controllerClass];

            foreach ($methodsMap as $method => $permissionsArray) {
                // Flatten ['can-update-organization', 'can-edit-global'] into "can-update-organization,can-edit-global"
                $argumentsString = implode(',', $permissionsArray);

                // Pass the strings securely into your middleware alias
                $middlewareSpecs[] = new Middleware(
                    "has_permissions:{$argumentsString}",
                    only: [$method]
                );
            }
        }

        return $middlewareSpecs;
    }
}

//permission will pass in middleware in argument as an array then will check and authorize
