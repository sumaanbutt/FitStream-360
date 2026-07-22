<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trainer extends Model
{
    protected $fillable = [
        'code',
        'business_code',
        'staff_code',
        'experience',
        'certifications',
        'specialization',
        'bio',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(
            Staff::class,
            'staff_code',
            'code'
        );
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(
            Business::class,
            'business_code',
            'code'
        );
    }
}
