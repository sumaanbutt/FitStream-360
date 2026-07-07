<?php

namespace App\Filters;

class BusinessFilter extends BaseFilter
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
                )
                ->orWhere(
                    'email',
                    'like',
                    "%{$value}%"
                )
                ->orWhere(
                    'phone',
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

    public function status(bool $value): void
    {
        $this->builder->where(
            'status',
            $value
        );
    }
}
