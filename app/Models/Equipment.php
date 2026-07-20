<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'created_by',
        'name',
        'description',
        'category',
        'equipment_image_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
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

    public function workoutPlanEquipments(): HasMany
    {
        return $this->hasMany(
            WorkoutPlanEquipment::class,
            'equipment_code',
            'code'
        );
    }
}
