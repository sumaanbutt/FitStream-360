<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
//            'business_code' => ['sometimes', 'exists:businesses,code',],
//            'staff_code' => ['nullable', 'exists:staff,code',],
            'business_code' => [
                'required_if:type,business',
                'nullable',
                'exists:businesses,code',
            ],

            'staff_code' => [
                'required_if:type,staff',
                'nullable',
                'exists:staff,code',
            ],

            'type' => ['sometimes',
                Rule::in([
                    'business',
                    'staff',
                ]),
            ],

            'address' => ['sometimes', 'string', 'max:500',],
            'city' => ['sometimes', 'string', 'max:100',],
            'state' => ['nullable', 'string', 'max:100',],
            'country' => ['sometimes', 'string', 'max:100',],
            'postal_code' => ['nullable', 'string', 'max:20',],
            'location_status' => ['sometimes',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
