<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraineeGoalProgress extends Model
{
    protected $fillable = [
        'code',
        'trainee_goal_code',
        'weight',
        'body_fat',
        'muscle_mass',
        'chest',
        'waist',
        'hips',
        'arms',
        'thighs',
        'progress_percentage',
        'notes',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',

            'weight' => 'decimal:2',
            'body_fat' => 'decimal:2',
            'muscle_mass' => 'decimal:2',

            'chest' => 'decimal:2',
            'waist' => 'decimal:2',
            'hips' => 'decimal:2',
            'arms' => 'decimal:2',
            'thighs' => 'decimal:2',

            'progress_percentage' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function traineeGoal(): BelongsTo
    {
        return $this->belongsTo(
            TraineeGoals::class,
            'trainee_goal_code',
            'code'
        );
    }
}
