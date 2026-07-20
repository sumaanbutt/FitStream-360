<?php

namespace App\Http\Requests\WorkoutDayExercise;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkoutDayExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workout_plan_code' => ['required', 'exists:workout_plans,code',],
            'workout_week_code' => ['required', 'exists:workout_weeks,code',],
            'workout_day_code' => ['required', 'exists:workout_days,code',],
            'exercise_code' => ['required', 'exists:exercises,code',],
            'sets' => ['nullable', 'integer', 'min:1',],
            'reps' => ['nullable', 'string', 'max:30',],
            'weight' => ['nullable', 'numeric', 'min:0',],
            'weight_unit' => ['nullable', 'string', 'max:10',],
            'duration_seconds' => ['nullable', 'integer', 'min:0',],
            'rest_seconds' => ['nullable', 'integer', 'min:0',],
            'distance' => ['nullable', 'numeric', 'min:0',],
            'distance_unit' => ['nullable', 'string', 'max:10',],
            'target_percentage' => ['nullable', 'numeric', 'between:0,100',],
            'target_rpe' => ['nullable', 'numeric', 'between:1,10',],
            'is_optional' => ['sometimes', 'boolean',],
            'instructions' => ['nullable', 'string',],
            'notes' => ['nullable', 'string',],
        ];
    }
}
