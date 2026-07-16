<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TraineeGoals extends Model
{
    protected $fillable=[
        'code',
        'trainee_code',
        'gym_goal_code',
        'user_code',
        'title',
        'description',
        'priority',
        'target_weight',
        'target_body_fat',
        'start_date',
        'target_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'target_date' => 'date',
            'target_weight' => 'decimal:2',
            'target_body_fat' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function trainee(): BelongsTo
    {
        return $this->belongsTo(
            Trainee::class,
            'trainee_code',
            'code'
        );
    }

    public function gymGoal(): BelongsTo
    {
        return $this->belongsTo(
            GymGoals::class,
            'gym_goal_code',
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

    public function attachments(): HasMany
    {
        return $this->hasMany(
            TraineeGoalsAttachments::class,
            'trainee_goal_code',
            'code'
        );
    }
}
