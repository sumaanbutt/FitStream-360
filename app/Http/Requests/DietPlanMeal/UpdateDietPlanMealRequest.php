<?php

namespace App\Http\Requests\DietPlanMeal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDietPlanMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'meal_type' => ['sometimes',
                Rule::in([
                    'breakfast',
                    'morning_snack',
                    'lunch',
                    'evening_snack',
                    'dinner',
                    'pre_workout',
                    'post_workout',
                ]),
            ],

            'title' => ['sometimes', 'string', 'max:255',],
            'description' => ['sometimes', 'nullable', 'string',],
            'recommended_time' => ['sometimes', 'nullable', 'date_format:H:i',],
            'estimated_calories' => ['sometimes', 'nullable', 'integer','min:0',],
            'protein' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'carbohydrates' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'fat' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'servings' => ['sometimes', 'integer', 'min:1',],
            'instructions' => ['sometimes', 'nullable', 'string',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
