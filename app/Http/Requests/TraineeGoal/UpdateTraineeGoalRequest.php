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

    public function rules(): array
    {
        return [
            'trainee_code' => ['sometimes', 'exists:trainees,code',],
            'gym_goal_code' => ['sometimes', 'exists:gym_goals,code',],
            'user_code' => ['sometimes', 'exists:users,code',],
            'title' => ['sometimes', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'target_weight' => ['sometimes', 'numeric', 'min:0',],
            'target_body_fat' => ['sometimes', 'numeric', 'min:0','max:100'],


            'start_date' => ['sometimes', 'date',],
            'target_date' => ['sometimes', 'date', 'after_or_equal:start_date',],
            'status' => ['sometimes',
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
