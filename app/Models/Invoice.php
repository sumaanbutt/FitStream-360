<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'code',
        'business_code',
        'order_code',
        'user_code',
        'invoice_number',
        'invoice_type',
        'payment_status',
        'subtotal',
        'discount',
        'tax',
        'total_amount',
        'payment_date',
    ];

    public function business()
    {
        return $this->belongsTo(
            Business::class,
            'business_code',
            'code'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_code',
            'code'
        );
    }

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'order_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
