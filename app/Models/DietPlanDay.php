<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietPlanDay extends Model
{
    protected $fillable = [
        'code',
        'diet_plan_code',
        'diet_plan_week_code',
        'day_number',
        'day_name',
        'title',
        'description',
        'target_calories',
        'target_protein',
        'target_carbohydrates',
        'target_fat',
        'water_target_liters',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_protein' => 'decimal:2',
            'target_carbohydrates' => 'decimal:2',
            'target_fat' => 'decimal:2',
            'water_target_liters' => 'decimal:2',
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
}
