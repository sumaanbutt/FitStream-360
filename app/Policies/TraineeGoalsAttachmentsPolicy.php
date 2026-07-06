<?php

namespace App\Policies;

use App\Models\TraineeGoalsAttachments;
use App\Models\User;

class TraineeGoalsAttachmentsPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('trainee-goal-attachment.viewAny');
    }

    public function view(User $user, TraineeGoalsAttachments $attachment): bool
    {
        return $user->can('trainee-goal-attachment.view');
    }

    public function create(User $user): bool
    {
        return $user->can('trainee-goal-attachment.create');
    }

    public function update(User $user, TraineeGoalsAttachments $attachment): bool
    {
        return $user->can('trainee-goal-attachment.update');
    }

    public function delete(User $user, TraineeGoalsAttachments $attachment): bool
    {
        return $user->can('trainee-goal-attachment.delete');
    }

}
