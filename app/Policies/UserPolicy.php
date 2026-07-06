<?php

namespace App\Policies;

use App\Models\TraineeGoals;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('user.viewAny');
    }

    public function view(user $user,): bool
    {
        return $user->can('user.view');
    }

    public function create(User $user): bool
    {
        return $user->can('user.create');
    }

}
