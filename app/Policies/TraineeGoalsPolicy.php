<?php

namespace App\Policies;

use App\Models\TraineeGoals;
use App\Models\User;

class TraineeGoalsPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('trainee-goal.view');
    }

    public function view(User $user, TraineeGoals $traineeGoal): bool
    {
        return $user->can('trainee-goal.view');
    }

    public function create(User $user): bool
    {
        return $user->can('trainee-goal.create');
    }

    public function update(User $user, TraineeGoals $traineeGoal): bool
    {
        return $user->can('trainee-goal.update');
    }

    public function delete(User $user, TraineeGoals $traineeGoal): bool
    {
        return $user->can('trainee-goal.delete');
    }

}
