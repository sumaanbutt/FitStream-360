<?php

namespace App\Http\Requests\DietPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreDietPlanRequest extends FormRequest
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
            'diet_type' => ['required', 'string', 'max:100',],
            'duration' => ['required', 'integer', 'min:1',],
            'duration_uom' => ['required', 'in:day,week,month,year',],
            'calories' => ['required', 'string', 'max:50',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:5120',],
            'status' => ['required', 'boolean',],
        ];
    }
}
