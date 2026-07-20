<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
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

            'food_category' => [
                'code' => $this->foodCategory?->code,
                'name' => $this->foodCategory?->name,
            ],

            'name' => $this->name,
            'description' => $this->description,
            'brand' => $this->brand,
            'serving_unit' => $this->serving_unit,
            'serving_size' => $this->serving_size,
            'calories' => $this->calories,
            'protein' => $this->protein,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'fiber' => $this->fiber,
            'image' => $this->image_path,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
