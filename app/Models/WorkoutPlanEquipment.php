<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutPlanEquipment extends Model
{
    protected $fillable = [
        'code',
        'workout_plan_code',
        'equipment_code',
        'quantity',
        'is_required',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
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

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(
            Equipment::class,
            'equipment_code',
            'code'
        );
    }
}
