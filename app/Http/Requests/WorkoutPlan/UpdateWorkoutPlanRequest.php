<?php

namespace App\Http\Requests\WorkoutPlan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkoutPlanRequest extends FormRequest
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
                    'strength',
                    'endurance',
                    'general_fitness',
                    'rehabilitation',
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

            'days_per_week' => [
                'sometimes',
                'integer',
                'between:1,7',
            ],

            'estimated_minutes_per_day' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
            ],

            'requires_gym' => [
                'sometimes',
                'boolean',
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
