<?php

namespace App\Http\Requests\WorkoutWeek;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkoutWeekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'workout_plan_code' => [
                'required',
                'exists:workout_plans,code',
            ],

            'week_number' => [
                'required',
                'integer',
                'min:1',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'instructions' => [
                'nullable',
                'string',
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
