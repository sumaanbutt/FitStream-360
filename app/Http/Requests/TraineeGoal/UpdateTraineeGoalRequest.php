<?php

namespace App\Http\Requests\TraineeGoal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTraineeGoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            'trainee_code' => ['sometimes', 'exists:trainees,code',],
            'title' => ['sometimes', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'target_value' => ['sometimes', 'numeric', 'min:0',],
            'target_unit' => ['sometimes',
                Rule::in([
                    'kg',
                    'lbs',
                    'cm',
                    'inch',
                    '%',
                    'days',
                    'weeks',
                    'months',
                    'reps',
                    'minutes',
                ]),
            ],

            'start_date' => ['sometimes', 'date',],
            'target_date' => ['sometimes', 'date', 'after_or_equal:start_date',],
            'status' => ['sometimes',
                Rule::in([
                    'pending',
                    'active',
                    'completed',
                    'cancelled',
                ]),
            ],

            'remarks' => ['nullable', 'string',],
        ];
    }

    public function messages(): array
    {
        return [
            'trainee_code.exists' => 'Selected trainee does not exist.',
            'target_date.after_or_equal' => 'Target date must be after or equal to start date.',
        ];
    }
}
