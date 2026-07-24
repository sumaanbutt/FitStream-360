<?php

namespace App\Http\Requests\Exercise;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_code' => ['required','exists:businesses,code'],
            'created_by' => ['sometimes','exists:users,code'],
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'exercise_type' => ['required',
                Rule::in([
                    'strength',
                    'cardio',
                    'stretching',
                    'mobility',
                    'plyometric',
                    'rehabilitation',
                    ]),
            ],
            'primary_muscle' => ['required',
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
                ])
            ],

            'secondary_muscles' => ['nullable','array'],
            'secondary_muscles.*' => ['string',],

            'difficulty' => ['required',
                Rule::in([
                    'beginner',
                    'intermediate',
                    'advanced',
                ])
            ],
            'instructions' => ['nullable', 'string'],
            'video_path' => ['nullable', 'url',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['required','boolean'],
        ];
    }
}
