<?php

namespace App\Http\Requests\TraineeGoal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeGoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'trainee_code' => ['required', 'exists:trainees,code',],
            'title' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'target_value' => ['required', 'numeric', 'min:0',],
            'target_unit' => ['required',
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

            'start_date' => ['required', 'date',],
            'target_date' => ['required', 'date',],

            'status' => ['required',
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
            'trainee_code.required' => 'Please select a trainee.',
            'trainee_code.exists' => 'Selected trainee does not exist.',
            'target_date.after_or_equal' => 'Target date must be after or equal to start date.',
        ];
    }
}
