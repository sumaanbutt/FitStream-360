<?php

namespace App\Filters;

class ProductFilter extends BaseFilter
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

    public function categoryCode(string $value): void
    {
        $this->builder->where(
            'category_code',
            $value
        );
    }

    public function subcategoryCode(string $value): void
    {
        $this->builder->where(
            'subcategory_code',
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
