<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_code' => ['nullable', 'exists:users,code',],

            'payment_method' => [
                'sometimes',
                Rule::in([
                    'cash',
                    'card',
                    'bank',
                ]),
            ],

            'subtotal' => ['sometimes', 'numeric', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0',],
            'tax' => ['nullable', 'numeric', 'min:0',],
            'total' => ['sometimes', 'numeric', 'min:0'],

            'status' => ['sometimes',
                Rule::in([
                    'pending', 'processing', 'shipped', 'completed', 'cancelled'
                ]),
            ],

            'payment_status' => ['sometimes',
                Rule::in([
                    'paid',
                    'unpaid',
                ]),
            ],

            'items' => ['sometimes', 'array', 'min:1',],
            'items.*.product_code' => ['required_with:items', 'exists:products,code',],
            'items.*.quantity' => ['required_with:items', 'integer', 'min:1',],
        ];
    }
}
