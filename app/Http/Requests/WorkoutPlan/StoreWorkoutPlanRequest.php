<?php

namespace App\Http\Requests\WorkoutPlan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkoutPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_code' => ['required', 'exists:businesses,code',],
            'title' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],

            'goal' => [
                'required',
                Rule::in([
                    'weight_loss',
                    'muscle_gain',
                    'strength',
                    'endurance',
                    'general_fitness',
                    'rehabilitation',
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

            'duration_weeks' => ['required', 'integer', 'min:1',],
            'days_per_week' => ['required', 'integer', 'between:1,7',],
            'estimated_minutes_per_day' => ['nullable', 'integer', 'min:1',],
            'requires_gym' => ['required', 'boolean',],
            'price' => ['required', 'numeric', 'min:0',],
            'currency' => ['required', 'string', 'size:3',],

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
