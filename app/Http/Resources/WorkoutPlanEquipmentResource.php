<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutPlanEquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'workout_plan' => [
                'code' => $this->workoutPlan?->code,
                'title' => $this->workoutPlan?->title,
            ],

            'equipment' => [
                'code' => $this->equipment?->code,
                'name' => $this->equipment?->name,
                'category' => $this->equipment?->category,
            ],

            'quantity' => $this->quantity,
            'is_required' => $this->is_required,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
