<?php

namespace App\Http\Requests\DietPlanMeal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDietPlanMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diet_plan_code' => ['required', 'exists:diet_plans,code',],
            'diet_plan_week_code' => ['required', 'exists:diet_plan_weeks,code',],
            'diet_plan_day_code' => ['required', 'exists:diet_plan_days,code',],
            'meal_type' => [
                'required',
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

            'title' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'recommended_time' => ['nullable', 'date_format:H:i',],
            'estimated_calories' => ['nullable', 'integer', 'min:0',],
            'protein' => ['nullable', 'numeric', 'min:0',],
            'carbohydrates' => ['nullable', 'numeric', 'min:0',],
            'fat' => ['nullable', 'numeric', 'min:0',],
            'servings' => ['required', 'integer', 'min:1',],
            'instructions' => ['nullable', 'string',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
