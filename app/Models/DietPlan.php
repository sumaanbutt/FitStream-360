<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DietPlan extends Model
{
    protected $fillable = [
        'code',
        'business_code',
        'created_by',
        'title',
        'description',
        'goal',
        'diet_type',
        'level',
        'gender',
        'duration_weeks',
        'meals_per_day',
        'target_calories',
        'target_protein',
        'target_carbohydrates',
        'target_fat',
        'price',
        'currency',
        'cover_image_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'target_protein' => 'decimal:2',
            'target_carbohydrates' => 'decimal:2',
            'target_fat' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(
            Business::class,
            'business_code',
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

    public function weeks(): HasMany
    {
        return $this->hasMany(
            DietPlanWeek::class,
            'diet_plan_code',
            'code'
        );
    }

    public function days(): HasMany
    {
        return $this->hasMany(
            DietPlanDay::class,
            'diet_plan_code',
            'code'
        );
    }
}
