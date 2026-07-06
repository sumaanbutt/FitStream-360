<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required', 'exists:organizations,code',],
            'business_code' => ['required', 'exists:businesses,code',],
            'user_code' => ['nullable', 'exists:users,code',],

            'payment_method' => ['required',
                Rule::in([
                    'cash',
                    'card',
                    'bank',
                ]),
            ],

            'payment_status' => ['required',
                Rule::in([
                    'paid' , 'unpaid'
                ])],

            'subtotal' => ['required', 'numeric', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0',],
            'tax' => ['nullable', 'numeric', 'min:0',],
            'total' => ['nullable', 'numeric', 'min:0',],

            'status' => ['required',
                Rule::in([
                    'pending', 'processing', 'shipped', 'completed', 'cancelled'
                ])],
            'items' => ['required', 'array'],
            'items.*.product_code' => ['required', 'exists:products,code',],
            'items.*.quantity' => ['required', 'integer', 'min:1',],
        ];
    }
}
