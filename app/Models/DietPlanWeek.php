<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DietPlanWeek extends Model
{
    protected $fillable = [
        'code',
        'diet_plan_code',
        'week_number',
        'title',
        'description',
        'target_calories',
        'target_protein',
        'target_carbohydrates',
        'target_fat',
        'instructions',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_protein' => 'decimal:2',
            'target_carbohydrates' => 'decimal:2',
            'target_fat' => 'decimal:2',
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

    public function days(): HasMany
    {
        return $this->hasMany(
            DietPlanDay::class,
            'diet_plan_week_code',
            'code'
        );
    }
}
