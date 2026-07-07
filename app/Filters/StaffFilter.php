<?php

namespace App\Filters;

class StaffFilter extends BaseFilter
{
    public function businessCode(string $value): void
    {
        $this->builder->where(
            'business_code',
            $value
        );
    }

    public function userCode(string $value): void
    {
        $this->builder->where(
            'user_code',
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

    public function joiningDate(string $value): void
    {
        $this->builder->whereDate(
            'joining_date',
            $value
        );
    }

    public function experience($value): void
    {
        $this->builder->where(
            'experience',
            '>=',
            $value
        );
    }
}
