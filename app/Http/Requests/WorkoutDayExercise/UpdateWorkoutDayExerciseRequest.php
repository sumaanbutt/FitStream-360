<?php

namespace App\Http\Requests\WorkoutDayExercise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutDayExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sets' => ['sometimes', 'nullable', 'integer', 'min:1',],
            'reps' => ['sometimes', 'nullable', 'string', 'max:30',],
            'weight' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'weight_unit' => ['sometimes', 'nullable', 'string', 'max:10',],
            'duration_seconds' => ['sometimes', 'nullable', 'integer', 'min:0',],
            'rest_seconds' => ['sometimes', 'nullable', 'integer', 'min:0',],
            'distance' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'distance_unit' => ['sometimes', 'nullable', 'string', 'max:10',],
            'target_percentage' => ['sometimes', 'nullable', 'numeric', 'between:0,100',],
            'target_rpe' => ['sometimes', 'nullable', 'numeric', 'between:1,10',],
            'is_optional' => ['sometimes', 'boolean',],
            'instructions' => ['sometimes', 'nullable', 'string',],
            'notes' => ['sometimes', 'nullable', 'string',],
        ];
    }
}
