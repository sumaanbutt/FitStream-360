<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'business_code' => ['required', 'exists:businesses,code',],
            'user_code' => ['required', 'exists:users,code',],
            'order_code' => ['required', 'exists:orders,code',],
            'invoice_type' => ['required', 'string', 'max:50'],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax' =>['nullable', 'numeric', 'min:0'],
            'total' => ['nullable', 'numeric', 'min:0'],

            'payment_method' => ['nullable',
                Rule::in([
                    'cash',
                    'card',
                    'bank',
                ]),
            ],

            'payment_status' => ['sometimes',
                Rule::in([
                    'paid',
                    'unpaid',
                    'overdue',
                    'cancelled'
                ]),
            ],

            'status' => ['sometimes',
                Rule::in([
                    'draft',
                    'issued',
                    'cancelled',
                ]),
            ],

        ];
    }
}
