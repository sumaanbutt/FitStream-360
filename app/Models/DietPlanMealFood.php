<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietPlanMealFood extends Model
{
    protected $table = 'diet_plan_meal_foods';
    protected $fillable = [
        'code',
        'diet_plan_meal_code',
        'food_code',
        'quantity',
        'unit',
        'calories',
        'protein',
        'carbohydrates',
        'fat',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'protein' => 'decimal:2',
            'carbohydrates' => 'decimal:2',
            'fat' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function dietPlanMeal(): BelongsTo
    {
        return $this->belongsTo(
            DietPlanMeal::class,
            'diet_plan_meal_code',
            'code'
        );
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(
            Food::class,
            'food_code',
            'code'
        );
    }
}
