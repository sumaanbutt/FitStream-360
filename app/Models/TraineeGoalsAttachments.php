<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraineeGoalsAttachments extends Model
{
    protected $fillable = [
        'code',
        'trainee_goal_code',
        'uploaded_by',
        'attachment_type',
        'file_name',
        'file_path',
        'description',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
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

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by',
            'code'
        );
    }
}
