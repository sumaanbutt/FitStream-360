<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'business_code' => ['required', 'exists:businesses,code',],
            'staff_code' => ['nullable', 'exists:staff,code',],

            'type' => ['required',
                Rule::in([
                    'business',
                    'staff',
                ]),
            ],

            'address' => ['required', 'string', 'max:500',],
            'city' => ['required', 'string', 'max:100',],
            'state' => ['nullable', 'string', 'max:100',],
            'country' => ['required', 'string', 'max:100',],
            'postal_code' => ['nullable', 'string', 'max:20',],
            'status' => ['sometimes',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
