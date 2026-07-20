<?php

namespace App\Http\Requests\DietPlanMealFood;

use Illuminate\Foundation\Http\FormRequest;

class StoreDietPlanMealFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diet_plan_meal_code' => ['required', 'exists:diet_plan_meals,code',],
            'food_code' => ['required', 'exists:foods,code',],
            'quantity' => ['required', 'numeric', 'min:0.01',],
            'unit' => ['required', 'string', 'max:30',],
            'calories' => ['nullable', 'integer', 'min:0',],
            'protein' => ['nullable', 'numeric', 'min:0',],
            'carbohydrates' => ['nullable', 'numeric', 'min:0',],
            'fat' => ['nullable', 'numeric', 'min:0',],
            'notes' => ['nullable', 'string',],
        ];
    }
}
