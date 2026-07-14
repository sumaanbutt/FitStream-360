<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Permission
{
    public function __construct(public array $permissions) {}

    public function authorize($user): void
    {
        if (! $user) {
            abort(403, 'This action is unauthorized.');
        }

            if ($user->can($this->permissions)) {
                return;
            }

        abort(403, 'This action is unauthorized.');
    }
}








