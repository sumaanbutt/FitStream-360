<?php

namespace App\Filters;

class TraineeGoalAttachmentFilter extends BaseFilter
{
    public function traineeGoalCode(string $value): void
    {
        $this->builder->where(
            'trainee_goal_code',
            $value
        );
    }

    public function uploadedBy(string $value): void
    {
        $this->builder->where(
            'uploaded_by',
            $value
        );
    }

    public function attachmentType(string $value): void
    {
        $this->builder->where(
            'attachment_type',
            $value
        );
    }
}
