<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_code' => ['required', 'exists:categories,code',],
            'sub_category_code' => ['required', 'exists:sub_categories,code',],
            'product_name' => ['required', 'string', 'max:255',],
            'product_description' => ['nullable', 'string',],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku',],
            'product_price' => ['required', 'numeric', 'min:0',],
            'quantity' => ['required', 'integer', 'min:0',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
