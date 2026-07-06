<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['sometimes',
                Rule::in([
                    'cash',
                    'card',
                    'bank',
                ]),
            ],

            'payment_status' => ['sometimes',
                Rule::in([
                    'pending',
                    'paid',
                    'failed',
                    'refunded',
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
