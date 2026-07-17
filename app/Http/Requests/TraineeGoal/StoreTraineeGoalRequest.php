<?php

namespace App\Http\Requests\TraineeGoal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required','exists:organizations,code',],
            'trainee_code' => ['nullable','exists:trainees,code',],
            'title' => ['required','string','max:100',],
            'description' => ['nullable','string',],
            'priority' => ['nullable','integer','between:1,5',],
            'target_weight' => ['nullable','numeric','min:0',],
            'target_body_fat' => ['nullable','numeric','min:0',],
            'start_date' => ['nullable','date',],
            'target_date' => ['nullable','date',],
            'goal_source' => ['required',
                Rule::in([
                    'gym',
                    'trainee',
                ]),
            ],

            'category' => ['required',
                Rule::in([
                    'body_composition',
                    'performance',
                    'health',
                    'lifestyle',
                    'sport',
                    'rehabilitation',
                    'other',
                ]),
            ],

            'status' => ['sometimes',
                Rule::in([
                    'active',
                    'completed',
                    'cancelled',
                ]),
            ],

            'notes' => ['nullable','string',],
        ];
    }
}
