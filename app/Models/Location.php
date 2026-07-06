<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'code',
        'business_code',
        'staff_code',
        'type',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'status',
    ];

    public function business()
    {
        return $this->belongsTo(
            Business::class,
            'business_code',
            'code'
        );
    }

    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'staff_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
