<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'code',
        'order_code',
        'product_code',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'order_code',
            'code'
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
