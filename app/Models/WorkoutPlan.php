<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutPlan extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'created_by',
        'title',
        'description',
        'goal',
        'level',
        'gender',
        'duration_weeks',
        'days_per_week',
        'estimated_minutes_per_day',
        'requires_gym',
        'price',
        'currency',
        'cover_image_path',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    protected function casts(): array
    {
        return [
            'requires_gym' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'code'
        );
    }

    public function weeks(): HasMany
    {
        return $this->hasMany(
            WorkoutWeek::class,
            'workout_plan_code',
            'code'
        );
    }

    public function days(): HasMany
    {
        return $this->hasMany(
            WorkoutDay::class,
            'workout_plan_code',
            'code'
        );
    }
}
