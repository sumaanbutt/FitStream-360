<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietPlanMealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'diet_plan' => [
                'code' => $this->dietPlan?->code,
                'title' => $this->dietPlan?->title,
            ],

            'diet_plan_week' => [
                'code' => $this->dietPlanWeek?->code,
                'week_number' => $this->dietPlanWeek?->week_number,
                'title' => $this->dietPlanWeek?->title,
            ],

            'diet_plan_day' => [
                'code' => $this->dietPlanDay?->code,
                'day_number' => $this->dietPlanDay?->day_number,
                'title' => $this->dietPlanDay?->title,
            ],

            'meal_type' => $this->meal_type,
            'title' => $this->title,
            'description' => $this->description,
            'recommended_time' => $this->recommended_time,
            'estimated_calories' => $this->estimated_calories,
            'protein' => $this->protein,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'servings' => $this->servings,
            'instructions' => $this->instructions,
            'status' => $this->status,
            'foods_count' => $this->whenCounted('mealFoods'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
