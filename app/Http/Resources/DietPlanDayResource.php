<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietPlanDayResource extends JsonResource
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

            'day_number' => $this->day_number,
            'day_name' => $this->day_name,
            'title' => $this->title,
            'description' => $this->description,
            'target_calories' => $this->target_calories,
            'target_protein' => $this->target_protein,
            'target_carbohydrates' => $this->target_carbohydrates,
            'target_fat' => $this->target_fat,
            'water_target_liters' => $this->water_target_liters,
            'notes' => $this->notes,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
