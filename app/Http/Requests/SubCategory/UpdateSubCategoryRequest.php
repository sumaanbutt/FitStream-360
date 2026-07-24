<?php

namespace App\Http\Requests\SubCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_code' => ['sometimes', 'exists:categories,code',],
            'name' => ['sometimes', 'string', 'max:255',
                Rule::unique('sub_categories')
//                    ->ignore($this->subCategory->id)
                    ->where(fn ($query) => $query->where(
                        'category_code',
                        $this->category_code ?? $this->subCategory->category_code
                    )),
            ],

            'status' => ['sometimes', 'boolean',],
        ];
    }
}
