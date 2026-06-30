<?php

namespace App\Policies;

use App\Models\Trainee;
use App\Models\User;

class TraineePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('trainee.view');
    }

    public function view(User $user, Trainee $trainee): bool
    {
        return $user->can('trainee.view');
    }

    public function create(User $user): bool
    {
        return $user->can('trainee.create');
    }

    public function update(User $user, Trainee $trainee): bool
    {
        return $user->can('trainee.update');
    }

    public function delete(User $user, Trainee $trainee): bool
    {
        return $user->can('trainee.delete');
    }
}
