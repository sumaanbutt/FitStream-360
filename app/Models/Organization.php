<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'code',
        'name',
        'address',
        'logo',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function businesses(): HasMany
    {
        return $this->hasMany(
            Business::class,
            'organization_code',
            'code'
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(
            User::class,
            'organization_code',
            'code'
        );
    }

    public function shiftSchedules()
    {
        return $this->hasMany(
            ShiftSchedule::class,
            'organization_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
