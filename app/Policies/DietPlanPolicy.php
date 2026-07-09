<?php

namespace App\Policies;

use App\Models\DietPlan;
use App\Models\User;

class DietPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('dietplan.viewAny');
    }

    public function view(User $user, DietPlan $dietPlan): bool
    {
        return $user->can('dietplan.view');
    }

    public function create(User $user): bool
    {
        return $user->can('dietplan.create');
    }

    public function update(User $user, DietPlan $dietPlan): bool
    {
        return $user->can('dietplan.update');
    }

    public function delete(User $user, DietPlan $dietPlan): bool
    {
        return $user->can('dietplan.delete');
    }
}
