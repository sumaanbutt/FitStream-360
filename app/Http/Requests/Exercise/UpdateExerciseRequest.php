<?php

namespace App\Http\Requests\Exercise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255',],
            'description' => ['sometimes', 'nullable', 'string',],
            'exercise_type' => ['sometimes',
                Rule::in([
                    'strength',
                    'cardio',
                    'stretching',
                    'mobility',
                    'plyometric',
                    'rehabilitation',
                ]),
            ],

            'primary_muscle' => ['sometimes',
                Rule::in([
                    'chest',
                    'back',
                    'shoulders',
                    'biceps',
                    'triceps',
                    'legs',
                    'glutes',
                    'abs',
                    'forearms',
                    'calves',
                    'full_body',
                ]),
            ],

            'secondary_muscles' => ['sometimes', 'nullable', 'array',],
            'secondary_muscles.*' => ['string',],

            'difficulty' => ['sometimes',
                Rule::in([
                    'beginner',
                    'intermediate',
                    'advanced',
                ]),
            ],

            'instructions' => ['sometimes', 'nullable', 'string',],
            'video_path' => ['sometimes', 'nullable', 'url',],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
