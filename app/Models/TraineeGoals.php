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
        'title',
        'description',
        'target_value',
        'target_unit',
        'start_date',
        'target_date',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'target_value' => 'decimal:2',
            'start_date' => 'date',
            'target_date' => 'date',
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

    public function attachments(): HasMany
    {
        return $this->hasMany(
            TraineeGoalsAttachments::class,
            'trainee_goal_code',
            'code'
        );
    }
}
