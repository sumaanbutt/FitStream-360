<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255',],
            'description' => ['sometimes', 'nullable', 'string',],
            'brand' => ['sometimes', 'nullable', 'string', 'max:255',],
            'serving_unit' => ['sometimes', 'string', 'max:30',],
            'serving_size' => ['sometimes', 'numeric', 'min:0.01',],
            'calories' => ['sometimes', 'integer', 'min:0',],
            'protein' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'carbohydrates' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'fat' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'fiber' => ['sometimes', 'nullable', 'numeric', 'min:0',],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
