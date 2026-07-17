<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutWeekResource extends JsonResource
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

            'week_number' => $this->week_number,

            'title' => $this->title,

            'description' => $this->description,

            'instructions' => $this->instructions,

            'status' => $this->status,

            'days_count' => $this->whenCounted('days'),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
