<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DietPlanMeal extends Model
{
    protected $fillable = [
        'code',
        'diet_plan_code',
        'diet_plan_week_code',
        'diet_plan_day_code',
        'meal_type',
        'title',
        'description',
        'recommended_time',
        'estimated_calories',
        'protein',
        'carbohydrates',
        'fat',
        'servings',
        'instructions',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'recommended_time' => 'datetime:H:i',
            'protein' => 'decimal:2',
            'carbohydrates' => 'decimal:2',
            'fat' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function dietPlan(): BelongsTo
    {
        return $this->belongsTo(
            DietPlan::class,
            'diet_plan_code',
            'code'
        );
    }

    public function dietPlanWeek(): BelongsTo
    {
        return $this->belongsTo(
            DietPlanWeek::class,
            'diet_plan_week_code',
            'code'
        );
    }

    public function dietPlanDay(): BelongsTo
    {
        return $this->belongsTo(
            DietPlanDay::class,
            'diet_plan_day_code',
            'code'
        );
    }

    public function mealFoods(): HasMany
    {
        return $this->hasMany(
            DietPlanMealFood::class,
            'diet_plan_meal_code',
            'code'
        );
    }
}
