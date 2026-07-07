<?php

namespace App\Filters;

class TraineeFilter extends BaseFilter
{
    public function businessCode(string $value): void
    {
        $this->builder->where(
            'business_code',
            $value
        );
    }

    public function organizationCode(string $value): void
    {
        $this->builder->where(
            'organization_code',
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

    public function gender(string $value): void
    {
        $this->builder->where(
            'gender',
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
