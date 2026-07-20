<?php

namespace App\Http\Requests\FoodCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required', 'exists:organizations,code',],
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'status' => ['sometimes', 'boolean',
            ],
        ];
    }
}
