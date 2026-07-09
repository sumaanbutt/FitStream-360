<?php

namespace App\Http\Requests\WorkoutPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkoutPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required', 'exists:organizations,code',],
            'title' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'workout_type' => ['required', 'string', 'max:100',],
            'duration' => ['required', 'integer', 'min:1',],
            'duration_uom' => ['required', 'in:day,week,month',],
//            'calories' => ['required', 'string', 'max:50',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:5120',],
            'status' => ['required', 'boolean',],
        ];
    }
}
