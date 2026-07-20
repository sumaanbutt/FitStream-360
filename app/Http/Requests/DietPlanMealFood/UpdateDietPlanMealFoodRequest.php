<?php

namespace App\Http\Requests\DietPlanMealFood;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDietPlanMealFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => ['sometimes', 'numeric', 'min:0.01',],
            'unit' => ['sometimes', 'string', 'max:30',],
            'calories' => ['sometimes', 'nullable', 'integer', 'min:0',],
            'protein' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'carbohydrates' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'fat' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'notes' => ['sometimes', 'nullable', 'string',
            ],
        ];
    }
}
