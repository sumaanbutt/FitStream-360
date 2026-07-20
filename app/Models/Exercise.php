<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'created_by',
        'name',
        'description',
        'exercise_type',
        'primary_muscle',
        'secondary_muscles',
        'difficulty',
        'instructions',
        'video_url',
        'image_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'secondary_muscles' => 'array',
            'status' => 'boolean',
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'code'
        );
    }

    public function workoutDayExercises(): HasMany
    {
        return $this->hasMany(
            WorkoutDayExercise::class,
            'exercise_code',
            'code'
        );
    }
}
