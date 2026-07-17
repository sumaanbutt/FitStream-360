<?php

namespace App\Http\Requests\TraineeGoalProgress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTraineeGoalProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trainee_goal_code' => ['sometimes', 'exists:trainee_goals,code',],
            'weight' => ['nullable', 'numeric', 'min:0',],
            'body_fat' => ['nullable', 'numeric', 'min:0','max:100',],
            'muscle_mass' => ['nullable', 'numeric', 'min:0',],
            'chest' => ['nullable', 'numeric', 'min:0',],
            'waist' => ['nullable', 'numeric', 'min:0',],
            'hips' => ['nullable', 'numeric', 'min:0',],
            'arms' => ['nullable', 'numeric', 'min:0',],
            'thighs' => ['nullable', 'numeric', 'min:0',],
            'notes' => ['nullable', 'string',],
            'recorded_at' => ['sometimes', 'date',],
        ];
    }
}
