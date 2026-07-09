<?php

namespace App\Http\Requests\WorkoutPlan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['sometimes', 'exists:organizations,code',],
            'title' => ['sometimes', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'workout_type' => ['sometimes', 'string', 'max:100',],
            'duration' => ['sometimes', 'integer', 'min:1',],
            'duration_uom' => ['sometimes', 'in:day,week,month',],
//            'calories' => ['sometimes', 'string', 'max:50',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:5120',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
