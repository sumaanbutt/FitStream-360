<?php

namespace App\Filters;

class InvoiceFilter extends BaseFilter
{
    public function businessCode(string $value): void
    {
        $this->builder->where(
            'business_code',
            $value
        );
    }

    public function orderCode(string $value): void
    {
        $this->builder->where(
            'order_code',
            $value
        );
    }

    public function paymentMethod(string $value): void
    {
        $this->builder->where(
            'payment_method',
            $value
        );
    }

    public function paymentStatus(string $value): void
    {
        $this->builder->where(
            'payment_status',
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
}
