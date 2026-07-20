<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutDayExercise extends Model
{
    protected $fillable = [
        'code',
        'workout_plan_code',
        'workout_week_code',
        'workout_day_code',
        'exercise_code',
        'sets',
        'reps',
        'weight',
        'weight_unit',
        'duration_seconds',
        'rest_seconds',
        'distance',
        'distance_unit',
        'target_percentage',
        'target_rpe',
        'is_optional',
        'instructions',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'distance' => 'decimal:2',
            'target_percentage' => 'decimal:2',
            'target_rpe' => 'decimal:1',
            'is_optional' => 'boolean',
        ];
    }

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

    public function workoutWeek(): BelongsTo
    {
        return $this->belongsTo(
            WorkoutWeek::class,
            'workout_week_code',
            'code'
        );
    }

    public function workoutDay(): BelongsTo
    {
        return $this->belongsTo(
            WorkoutDay::class,
            'workout_day_code',
            'code'
        );
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(
            Exercise::class,
            'exercise_code',
            'code'
        );
    }
}
