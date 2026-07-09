<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkoutPlan;

class WorkoutPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('workout.viewAny');
    }

    public function view(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->can('workout.view');
    }

    public function create(User $user): bool
    {
        return $user->can('workout.create');
    }

    public function update(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->can('workout.update');
    }

    public function delete(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->can('workout.delete');
    }
}
