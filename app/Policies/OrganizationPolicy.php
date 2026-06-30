<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('organization.view');
    }

    public function view(User $user, Organization $organization): bool
    {
        return $user->can('organization.view');
    }

    public function create(User $user): bool
    {
        return $user->can('organization.create');
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->can('organization.update');
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->can('organization.delete');
    }
}
