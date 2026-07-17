<?php

namespace App\Http\Requests\WorkoutDay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkoutDayRequest extends FormRequest
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

            'workout_week_code' => [
                'required',
                'exists:workout_weeks,code',
            ],

            'day_number' => [
                'required',
                'integer',
                'between:1,7',
            ],

            'day_name' => [
                'required',
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
                'required',
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

            'estimated_duration' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'is_rest_day' => [
                'required',
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
