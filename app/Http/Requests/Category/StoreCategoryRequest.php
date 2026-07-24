<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'business_code' => 'required|string|exists:businesses,code',
            'name' => ['required', 'string', 'max:255', 'unique:categories,name',],
            'description' => ['nullable', 'string',],
//            'status' => ['required', 'boolean',],
        ];
    }

    public function messages(): array
    {
        return [
            'business_code.required' => 'Business field is required.',
            'name.required' => 'Category name is required.',
            'name.unique' => 'Category name already exists.',
        ];
    }
}
