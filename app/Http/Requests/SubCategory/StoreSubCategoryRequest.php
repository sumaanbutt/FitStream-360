<?php

namespace App\Http\Requests\SubCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_code' => ['required', 'exists:categories,code',],
            'name' => ['required', 'string', 'max:255',
                Rule::unique('sub_categories')
                    ->where(fn ($query) => $query->where('category_code', $this->category_code)),
            ],

            'status' => ['sometimes', 'boolean',],
        ];
    }

    public function messages(): array
    {
        return [
            'category_code.required' => 'Category is required.',
            'category_code.exists' => 'Selected category does not exist.',
            'name.unique' => 'This sub category already exists in the selected category.',
        ];
    }
}
