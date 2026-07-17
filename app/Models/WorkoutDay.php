<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutDay extends Model
{
    protected $fillable = [
        'code',
        'workout_plan_code',
        'workout_week_code',
        'day_number',
        'day_name',
        'title',
        'description',
        'instructions',
        'estimated_duration',
        'is_rest_day',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_rest_day' => 'boolean',
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
}
