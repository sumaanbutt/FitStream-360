<?php

namespace App\Http\Requests\TraineeGoal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTraineeGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes','string','max:100',],
            'description' => ['nullable','string',],
            'priority' => ['nullable','integer','between:1,5',],
            'target_weight' => ['nullable','numeric','min:0',],
            'target_body_fat' => ['nullable','numeric','min:0',],
            'start_date' => ['nullable','date',],
            'target_date' => ['nullable','date',],

            'category' => ['sometimes',
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
