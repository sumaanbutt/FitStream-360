<?php

namespace App\Http\Requests\WorkoutPlanEquipment;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkoutPlanEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workout_plan_code' => ['required', 'exists:workout_plans,code',],
            'equipment_code' => ['required', 'exists:equipments,code',],
            'quantity' => ['required', 'integer', 'min:1',],
            'is_required' => ['sometimes', 'boolean',],
            'notes' => ['nullable', 'string',],
        ];
    }
}
