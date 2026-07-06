<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;

class LocationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('location.viewAny');
    }

    public function view(User $user, Location $location): bool
    {
        return $user->can('location.view');
    }

    public function create(User $user): bool
    {
        return $user->can('location.create');
    }

    public function update(User $user, Location $location): bool
    {
        return $user->can('location.update');
    }

    public function delete(User $user, Location $location): bool
    {
        return $user->can('location.delete');
    }
}
