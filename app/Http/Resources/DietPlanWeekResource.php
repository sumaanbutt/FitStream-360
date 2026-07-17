<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietPlanWeekResource extends JsonResource
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

            'week_number' => $this->week_number,
            'title' => $this->title,
            'description' => $this->description,
            'target_calories' => $this->target_calories,
            'target_protein' => $this->target_protein,
            'target_carbohydrates' => $this->target_carbohydrates,
            'target_fat' => $this->target_fat,
            'instructions' => $this->instructions,
            'status' => $this->status,
            'days_count' => $this->whenCounted('days'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
