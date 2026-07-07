<?php

namespace App\Filters;

class TraineeGoalFilter extends BaseFilter
{
    public function traineeCode(string $value): void
    {
        $this->builder->where(
            'trainee_code',
            $value
        );
    }

    public function status(string $value): void
    {
        $this->builder->where(
            'status',
            $value
        );
    }

    public function targetUnit(string $value): void
    {
        $this->builder->where(
            'target_unit',
            $value
        );
    }

    public function startDate(string $value): void
    {
        $this->builder->whereDate(
            'start_date',
            $value
        );
    }

    public function targetDate(string $value): void
    {
        $this->builder->whereDate(
            'target_date',
            $value
        );
    }
}
