<?php

namespace App\Filters;

class LocationFilter extends BaseFilter
{
    public function search(string $value): void
    {
        $this->builder->where(function ($query) use ($value) {

            $query->where(
                'code',
                'like',
                "%{$value}%"
            )
                ->orWhere(
                    'name',
                    'like',
                    "%{$value}%"
                );

        });
    }

    public function organizationCode(string $value): void
    {
        $this->builder->where(
            'organization_code',
            $value
        );
    }

    public function businessCode(string $value): void
    {
        $this->builder->where(
            'business_code',
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

    public function locationType(string $value): void
    {
        $this->builder->where(
            'location_type',
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
