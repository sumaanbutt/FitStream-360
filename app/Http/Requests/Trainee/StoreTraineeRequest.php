<?php

namespace App\Http\Requests\Trainee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

// User Type:
            'user_type' => ['required', Rule::in(['existing', 'new']),],

// Existing User:
            'user_code' => ['required_if:user_type,existing', 'nullable', 'exists:users,code',],

// New User:
            'organization_code' => ['required_if:user_type,new', 'nullable', 'exists:organizations,code',],
            'name' => ['required_if:user_type,new', 'nullable', 'string', 'max:255',],
            'email' => ['required_if:user_type,new', 'nullable', 'email', 'unique:users,email',],
            'phone' => ['nullable', 'string', 'max:20',],
            'password' => ['required_if:user_type,new', 'nullable', 'confirmed', 'min:8',],

// Trainee:
            'trainee_type' => [
                'required',
                Rule::in([
                    'organization',
                    'business',
                ]),
            ],
            'business_code' => ['required', 'exists:businesses,code',],

            'gender' => ['nullable', Rule::in([
                    'male',
                    'female',
                    'other',
                ]),
            ],

            'age' => ['nullable', 'integer', 'min:1'],
            'height' => ['nullable', 'numeric', 'min:1'],
            'weight' => ['nullable', 'numeric', 'min:1'],
            'joining_date' => ['required', 'date',],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_type.required' => 'Please select user type.',
            'user_code.required_if' => 'User Code is required.',
            'organization_code.required_if' => 'Organization Code is required.',
            'name.required_if' => 'Name is required.',
            'email.required_if' => 'Email is required.',
            'password.required_if' => 'Password is required.',
        ];
    }
}
