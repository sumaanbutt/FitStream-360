<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutDayResource extends JsonResource
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

            'workout_week' => [
                'code' => $this->workoutWeek?->code,
                'week_number' => $this->workoutWeek?->week_number,
                'title' => $this->workoutWeek?->title,
            ],

            'day_number' => $this->day_number,

            'day_name' => $this->day_name,

            'title' => $this->title,

            'description' => $this->description,

            'instructions' => $this->instructions,

            'estimated_duration' => $this->estimated_duration,

            'is_rest_day' => $this->is_rest_day,

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
