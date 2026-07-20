<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietPlanMealFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'diet_plan_meal' => [
                'code' => $this->dietPlanMeal?->code,
                'title' => $this->dietPlanMeal?->title,
            ],

            'food' => [
                'code' => $this->food?->code,
                'name' => $this->food?->name,
            ],

            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'calories' => $this->calories,
            'protein' => $this->protein,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
