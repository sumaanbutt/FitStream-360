<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;

class BusinessPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('business.view');
    }

    public function view(User $user, Business $business): bool
    {
        return $user->can('business.view');
    }

    public function create(User $user): bool
    {
        return $user->can('business.create');
    }

    public function update(User $user, Business $business): bool
    {
        return $user->can('business.update');
    }

    public function delete(User $user, Business $business): bool
    {
        return $user->can('business.delete');
    }
}
