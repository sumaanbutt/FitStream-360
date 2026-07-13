<?php

namespace App\Attributes;

use Attribute;
use ReflectionMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class Permission
{
    public function __construct(public array $permissions) {}

    public function authorize($user): void
    {
        if (! $user) {
            abort(403, 'This action is unauthorized.');
        }

//        foreach ($this->permissions as $permission) {
            if ($user->can($this->permissions)) {
                return;
            }


        abort(403, 'This action is unauthorized.');
    }

    public static function watch(object $controller, string $method, array $parameters)
    {
        try {
            $reflection = new ReflectionMethod($controller, $method);
            $attributes = $reflection->getAttributes(self::class);

            if (! empty($attributes)) {

                $user = auth()->user();

                $attributes[0]->newInstance()->authorize($user);

            } else {
                abort(403, "Security Error: Missing #[Permission] attribute on " . get_class($controller) . "@{$method}");
            }
        } catch (\ReflectionException $e) {
            abort(403, 'Authorization reflection error.');
        }

        return call_user_func_array([$controller, $method], $parameters);
    }
}
