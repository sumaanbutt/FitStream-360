<?php

namespace App\Http\Requests\WorkoutDay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkoutDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workout_week_code' => ['nullable',],

            'day_number' => [
                'sometimes',
                'integer',
                'between:1,7',
            ],

            'day_name' => [
                'sometimes',
                Rule::in([
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                ]),
            ],

            'title' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'instructions' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'estimated_duration' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
            ],

            'is_rest_day' => [
                'sometimes',
                'boolean',
            ],

            'status' => [
                'sometimes',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
