<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'business' => [
                'code' => $this->business?->code,
                'name' => $this->business?->name,
            ],

            'created_by' => [
                'code' => $this->creator?->code,
                'name' => $this->creator?->name,
            ],

            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'image' => $this->equipment_image_path,
            'status' => $this->status,

            'workout_plans_count' => $this->whenCounted(
                'workoutPlanEquipments'
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
