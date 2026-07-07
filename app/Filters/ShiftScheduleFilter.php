<?php

namespace App\Filters;

class ShiftScheduleFilter extends BaseFilter
{
    public function organizationCode(string $value): void
    {
        $this->builder->where(
            'organization_code',
            $value
        );
    }

    public function staffCode(string $value): void
    {
        $this->builder->where(
            'staff_code',
            $value
        );
    }

    public function workingDay(string $value): void
    {
        $this->builder->where(
            'working_day',
            $value
        );
    }

    public function status(bool $value): void
    {
        $this->builder->where(
            'status',
            $value
        );
    }
}
