<?php

namespace App\Filters;

class DietPlanFilter extends BaseFilter
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
                    'title',
                    'like',
                    "%{$value}%"
                )
                ->orWhere(
                    'description',
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

    public function createdBy(string $value): void
    {
        $this->builder->where(
            'created_by',
            $value
        );
    }

    public function dietType(string $value): void
    {
        $this->builder->where(
            'diet_type',
            $value
        );
    }

    public function duration(string $value): void
    {
        $this->builder->where(
            'duration',
            $value
        );
    }

    public function durationUom(string $value): void
    {
        $this->builder->where(
            'duration_uom',
            $value
        );
    }

    public function calories(string $value): void
    {
        $this->builder->where(
            'calories',
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
