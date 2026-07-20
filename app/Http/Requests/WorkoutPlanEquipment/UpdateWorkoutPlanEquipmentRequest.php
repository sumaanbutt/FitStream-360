<?php

namespace App\Http\Requests\WorkoutPlanEquipment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutPlanEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => ['sometimes', 'integer', 'min:1',],
            'is_required' => ['sometimes', 'boolean',],
            'notes' => ['sometimes', 'nullable', 'string',
            ],
        ];
    }
}
