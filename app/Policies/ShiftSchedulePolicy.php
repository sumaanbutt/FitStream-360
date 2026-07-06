<?php

namespace App\Policies;

use App\Models\ShiftSchedule;
use App\Models\User;

class ShiftSchedulePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('shiftschedule.viewAny');
    }

    public function view(User $user, ShiftSchedule $shiftSchedule): bool
    {
        return $user->can('shiftschedule.view');
    }

    public function create(User $user): bool
    {
        return $user->can('shiftschedule.create');
    }

    public function update(User $user, ShiftSchedule $shiftSchedule): bool
    {
        return $user->can('shiftschedule.update');
    }

    public function delete(User $user, ShiftSchedule $shiftSchedule): bool
    {
        return $user->can('shiftschedule.delete');
    }
}
