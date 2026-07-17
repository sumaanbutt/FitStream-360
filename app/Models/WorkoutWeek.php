<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutWeek extends Model
{
    protected $fillable = [
        'code',
        'workout_plan_code',
        'week_number',
        'title',
        'description',
        'instructions',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function workoutPlan(): BelongsTo
    {
        return $this->belongsTo(
            WorkoutPlan::class,
            'workout_plan_code',
            'code'
        );
    }

    public function days(): HasMany
    {
        return $this->hasMany(
            WorkoutDay::class,
            'workout_week_code',
            'code'
        );
    }
}
