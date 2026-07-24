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
            'house' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],

            'blood_group' => ['nullable', Rule::in([
                'A+','A-','B+','B-','AB+','AB-','O+','O-'
            ])],

            'emergency_contact_name' => ['nullable', 'string'],
            'emergency_contact_phone' => ['nullable', 'string'],

            'allergies' => ['nullable', 'string'],
            'medical_conditions' => ['nullable', 'string'],

            'allowed_locations' => ['nullable', 'array'],
            'allowed_locations.*' => ['exists:locations,code'],

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
