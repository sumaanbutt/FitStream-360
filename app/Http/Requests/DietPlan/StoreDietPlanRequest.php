<?php

namespace App\Http\Requests\DietPlan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDietPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'organization_code' => [
                'required',
                'exists:organizations,code',
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

            'goal' => [
                'required',
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
                'required',
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
                'required',
                Rule::in([
                    'beginner',
                    'intermediate',
                    'advanced',
                ]),
            ],

            'gender' => [
                'required',
                Rule::in([
                    'male',
                    'female',
                    'unisex',
                ]),
            ],

            'duration_weeks' => [
                'required',
                'integer',
                'min:1',
            ],

            'meals_per_day' => [
                'required',
                'integer',
                'between:1,10',
            ],

            'target_calories' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'target_protein' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_carbohydrates' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_fat' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'currency' => [
                'required',
                'string',
                'size:3',
            ],

            'cover_image' => [
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
