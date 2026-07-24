<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_code' => ['sometimes', 'exists:categories,code',],
            'subcategory_code' => ['sometimes', 'exists:sub_categories,code',],
            'product_name' => ['sometimes', 'string', 'max:255',],
            'product_description' => ['sometimes', 'string',],
            'sku' => ['sometimes', 'string',
                Rule::unique('products', 'sku')
                    ->ignore($this->product->code),
            ],
            'product_price' => ['sometimes', 'numeric', 'min:0',],
            'quantity' => ['sometimes', 'integer', 'min:0',],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
