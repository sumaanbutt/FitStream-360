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
            'gym_goal_code' => ['required', 'exists:gym_goals,code',],
            'user_code' => ['nullable', 'exists:users,code',],
            'title' => ['nullable', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'priority' => ['nullable', 'integer', 'between:1,5',],
            'target_weight' => ['nullable', 'numeric', 'min:0',],
            'target_body_fat' => ['nullable', 'numeric', 'min:0','max:100',],
            'start_date' => ['required', 'date',],
            'target_date' => ['required', 'date',],

            'status' => ['required',
                Rule::in([
                    'active',
                    'completed',
                    'cancelled',
                ]),
            ],

            'notes' => ['nullable', 'string',],
        ];
    }

    public function messages(): array
    {
        return [
            'trainee_code.exists' => 'Selected trainee does not exist.',
            'gym_goal_code.exists' => 'Selected gym goal does not exist.',
            'user_code.exists' => 'Selected user does not exist.',
        ];
    }
}
