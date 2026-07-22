<?php

namespace App\Http\Requests\Trainee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTraineeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->trainee?->user?->id;

        return [
// User:
            'organization_code' => ['sometimes', 'exists:organizations,code',],
            'business_code' => ['sometimes', 'exists:businesses,code',],
            'name' => ['sometimes', 'string', 'max:255',],
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($userId),],
            'phone' => ['nullable', 'string', 'max:20',],
            'password' => ['sometimes', 'confirmed', 'min:8',],

// Trainee:
            'trainee_type' => [
                'required',
                Rule::in([
                    'organization',
                    'business',
                ]),
            ],

            'gender' => ['sometimes',
                Rule::in([
                    'male',
                    'female',
                    'other',
                ]),
            ],
            'age' => ['sometimes', 'integer', 'min:1',],
            'height' => ['sometimes', 'numeric', 'min:1',],
            'weight' => ['sometimes', 'numeric', 'min:1',],
            'joining_date' => ['sometimes', 'date',],
            'status' => ['sometimes', 'boolean',],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email already exists.',
            'business_code.exists' => 'Business not found.',
            'organization_code.exists' => 'Organization not found.',
        ];
    }
}
