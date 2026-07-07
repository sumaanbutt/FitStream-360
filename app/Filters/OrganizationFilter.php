<?php

namespace App\Filters;

class OrganizationFilter extends BaseFilter
{
    public function search(string $value): void
    {
        $this->builder->where(function ($query) use ($value) {

            $query->where('code', 'like', "%{$value}%")
                ->orWhere('name', 'like', "%{$value}%")
                ->orWhere('address', 'like', "%{$value}%");
        });
    }

    public function status(bool $value): void
    {
        $this->builder->where(
            'status',
            $value
        );
    }
}
