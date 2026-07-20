<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
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

            'name' => $this->name,
            'description' => $this->description,
            'exercise_type' => $this->exercise_type,
            'primary_muscle' => $this->primary_muscle,
            'secondary_muscles' => $this->secondary_muscles,
            'difficulty' => $this->difficulty,
            'instructions' => $this->instructions,
            'video' => $this->video_url,
            'image' => $this->image_path,
            'status' => $this->status,

            'workout_days_count' => $this->whenCounted(
                'workoutDayExercises'
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
