<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietPlanResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'organization' => [
                'code' => $this->organization?->code,
                'name' => $this->organization?->name,
            ],

            'created_by' => [
                'code' => $this->creator?->code,
                'name' => $this->creator?->name,
            ],

            'title' => $this->title,
            'description' => $this->description,
            'goal' => $this->goal,
            'diet_type' => $this->diet_type,
            'level' => $this->level,
            'gender' => $this->gender,
            'duration_weeks' => $this->duration_weeks,
            'meals_per_day' => $this->meals_per_day,
            'target_calories' => $this->target_calories,
            'target_protein' => $this->target_protein,
            'target_carbohydrates' => $this->target_carbohydrates,
            'target_fat' => $this->target_fat,
            'price' => $this->price,
            'currency' => $this->currency,
            'cover_image' => $this->cover_image_path,
            'status' => $this->status,
            'weeks_count' => $this->whenCounted('weeks'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
