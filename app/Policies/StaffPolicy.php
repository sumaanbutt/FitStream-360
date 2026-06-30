<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\User;

class StaffPolicy
{
    /**
     * Display all staff.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('staff.view');
    }

    /**
     * Display single staff.
     */
    public function view(User $user, Staff $staff): bool
    {
        return $user->can('staff.view');
    }

    /**
     * Create staff.
     */
    public function create(User $user): bool
    {
        return $user->can('staff.create');
    }

    /**
     * Update staff.
     */
    public function update(User $user, Staff $staff): bool
    {
        return $user->can('staff.update');
    }

    /**
     * Delete staff.
     */
    public function delete(User $user, Staff $staff): bool
    {
        return $user->can('staff.delete');
    }

    /**
     * Restore staff.
     */
    public function restore(User $user, Staff $staff): bool
    {
        return false;
    }

    /**
     * Permanently delete staff.
     */
    public function forceDelete(User $user, Staff $staff): bool
    {
        return false;
    }
}
