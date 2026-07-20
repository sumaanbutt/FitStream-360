<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'created_by',
        'food_category_code',
        'name',
        'description',
        'brand',
        'serving_unit',
        'serving_size',
        'calories',
        'protein',
        'carbohydrates',
        'fat',
        'fiber',
        'image_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'serving_size' => 'decimal:2',
            'protein' => 'decimal:2',
            'carbohydrates' => 'decimal:2',
            'fat' => 'decimal:2',
            'fiber' => 'decimal:2',
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

    public function foodCategory(): BelongsTo
    {
        return $this->belongsTo(
            FoodCategory::class,
            'food_category_code',
            'code'
        );
    }

    public function mealFoods(): HasMany
    {
        return $this->hasMany(
            DietPlanMealFood::class,
            'food_code',
            'code'
        );
    }
}
