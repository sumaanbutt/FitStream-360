<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

// User Information:
            'organization_code' => ['sometimes', 'exists:organizations,code',],
            'business_code' => ['sometimes', 'exists:businesses,code',],
            'name' => ['sometimes', 'string', 'max:255',],

            'email' => ['sometimes', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore(
                    $this->staff->user->id
                ),
            ],

            'phone' => ['nullable', 'string', 'max:20',],
            'password' => ['nullable', 'string', 'min:8', 'confirmed',],

// Staff Information:
            'role' => [
                'sometimes',
                Rule::in([
                    'Trainer',
                    'Receptionist',
                    'Nutritionist',
                    'Staff',
                ]),
            ],

//          'business_code' => ['sometimes', 'exists:businesses,code',],
            'salary' => ['sometimes', 'numeric', 'min:0',],
            'joining_date' => ['sometimes', 'date',],
            'experience' => ['nullable', 'integer', 'min:0',],
            'certifications' => ['nullable', 'string',],
            'status' => ['sometimes', 'boolean',],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already taken.',
            'business_code.exists' => 'Selected business does not exist.',
            'organization_code.exists' => 'Selected organization does not exist.',
        ];
    }
}
