<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class   Order extends Model
{
    protected $fillable = [
        'code',

        'organization_code',
        'user_code',

        'subtotal',
        'discount',
        'tax',
        'total',

        'payment_method',
        'payment_status',

        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

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

    public function invoice()
    {
        return $this->belongsTo(
            Invoice::class,
            'invoice_code',
            'code'
        );
    }

    public function items()
    {
        return $this->hasMany(
            OrderItem::class,
            'order_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
