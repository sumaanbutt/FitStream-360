<?php

namespace App\Http\Requests\DietPlan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDietPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

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

            'goal' => [
                'sometimes',
                Rule::in([
                    'weight_loss',
                    'muscle_gain',
                    'maintenance',
                    'performance',
                    'general_health',
                    'other',
                ]),
            ],

            'diet_type' => [
                'sometimes',
                Rule::in([
                    'balanced',
                    'high_protein',
                    'low_carb',
                    'keto',
                    'vegetarian',
                    'vegan',
                    'other',
                ]),
            ],

            'level' => [
                'sometimes',
                Rule::in([
                    'beginner',
                    'intermediate',
                    'advanced',
                ]),
            ],

            'gender' => [
                'sometimes',
                Rule::in([
                    'male',
                    'female',
                    'unisex',
                ]),
            ],

            'duration_weeks' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'meals_per_day' => [
                'sometimes',
                'integer',
                'between:1,10',
            ],

            'target_calories' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
            ],

            'target_protein' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_carbohydrates' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_fat' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'currency' => [
                'sometimes',
                'string',
                'size:3',
            ],

            'cover_image' => [
                'sometimes',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'sometimes',
                Rule::in([
                    'draft',
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
