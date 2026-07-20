<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required', 'exists:organizations,code',],
            'food_category_code' => ['nullable', 'exists:food_categories,code',],
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'brand' => ['nullable', 'string', 'max:255',],
            'serving_unit' => ['required', 'string', 'max:30',],
            'serving_size' => ['required', 'numeric', 'min:0.01',],
            'calories' => ['required', 'integer', 'min:0',],
            'protein' => ['nullable', 'numeric', 'min:0',],
            'carbohydrates' => ['nullable', 'numeric', 'min:0',],
            'fat' => ['nullable', 'numeric', 'min:0',],
            'fiber' => ['nullable', 'numeric', 'min:0',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
