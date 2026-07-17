<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraineeGoals extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'trainee_code',
        'created_by',
        'title',
        'description',
        'priority',
        'target_weight',
        'target_body_fat',
        'start_date',
        'target_date',
        'goal_source',
        'category',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'target_date' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

    public function trainee(): BelongsTo
    {
        return $this->belongsTo(
            Trainee::class,
            'trainee_code',
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

    public function attachments()
    {
        return $this->hasMany(
            TraineeGoalsAttachments::class,
            'trainee_goal_code',
            'code'
        );
    }

    public function progress()
    {
        return $this->hasMany(
            TraineeGoalProgress::class,
            'trainee_goal_code',
            'code'
        );
    }
}
