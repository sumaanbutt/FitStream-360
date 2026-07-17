<?php
//
//namespace App\Http\Middleware;
//
//use App\Attributes\Permission;
//use Closure;
//use Illuminate\Http\Request;
//use ReflectionMethod;
//use Symfony\Component\HttpFoundation\Response;
//
//class CheckPermissions
//{
//    public function handle(Request $request, Closure $next): Response
//    {
//        $route = $request->route();
//
//        if (! $route) {
//            return $next($request);
//        }
//
//        $controller = $route->getController();
//        $method = $route->getActionMethod();
//
//        if (! $controller || ! $method) {
//            return $next($request);
//        }
//
//        $controllerClass = class_basename($controller);
//        $excludedControllers = [
//            'AuthenticatedSessionController', 'RegisteredUserController',
//            'PasswordResetLinkController', 'NewPasswordController',
//            'ConfirmablePasswordController', 'EmailVerificationNotificationController',
//            'VerifyEmailController',
//        ];
//
//        if (in_array($controllerClass, $excludedControllers)) {
//            return $next($request);
//        }
//
//        try {
//            $reflection = new ReflectionMethod($controller, $method);
//            $attributes = $reflection->getAttributes(Permission::class);
//
//            if (! empty($attributes)) {
//                $permissionsArray = $attributes[0]->newInstance()->permissions;
//
//                $user = auth()->user();
//                if (! $user) {
//                    abort(401, 'Unauthenticated.');
//                }
//
//                foreach ($permissionsArray as $permission) {
//                    if ($user->can($permission)) {
//                        return $next($request);
//                    }
//                }
//
//                abort(403, 'This action is unauthorized.');
//            }
//
//            abort(403, "Security Error: User doesn't have permission for this action.");
//
//        } catch (\ReflectionException $e) {
//            abort(403, 'Authorization reflection error.');
//        }
//    }
//}

//permission check against role if the that role has permission than ok otherwise
//i want all work to be done in custom attribute that will than call in controller, if i want to use middleware , i can apply that directly on route so i dont want that
