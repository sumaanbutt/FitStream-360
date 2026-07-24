<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trainee extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'business_code',
        'user_code',
        'trainee_type',
        'gender',
        'age',
        'height',
        'weight',
        'address',
        'blood_group',
        'emergency_contact_name',
        'emergency_contact_phone',
        'allergies',
        'medical_conditions',
        'allowed_locations',
        'joining_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'height' => 'decimal:2',
            'weight' => 'decimal:2',
            'joining_date' => 'date',
            'status' => 'boolean',
            'allowed_locations' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

// Relationships

    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_code',
            'code'
        );
    }

    public function goals()
    {
        return $this->hasMany(
            TraineeGoal::class,
            'trainee_code',
            'code'
        );
    }
}
