<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutDayExerciseResource extends JsonResource
{
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

            'workout_day' => [
                'code' => $this->workoutDay?->code,
                'day_number' => $this->workoutDay?->day_number,
                'title' => $this->workoutDay?->title,
            ],

            'exercise' => [
                'code' => $this->exercise?->code,
                'name' => $this->exercise?->name,
                'exercise_type' => $this->exercise?->exercise_type,
                'primary_muscle' => $this->exercise?->primary_muscle,
                'difficulty' => $this->exercise?->difficulty,
            ],

            'sets' => $this->sets,
            'reps' => $this->reps,
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'duration_seconds' => $this->duration_seconds,
            'rest_seconds' => $this->rest_seconds,
            'distance' => $this->distance,
            'distance_unit' => $this->distance_unit,
            'target_percentage' => $this->target_percentage,
            'target_rpe' => $this->target_rpe,
            'is_optional' => $this->is_optional,
            'instructions' => $this->instructions,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
