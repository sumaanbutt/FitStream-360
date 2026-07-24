<?php

namespace App\Http\Requests\Trainee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


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

            'joining_date' => ['required', 'date',],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => 'Please select user type.',
            'user_code.required_if' => 'User Code is required.',
            'organization_code.required_if' => 'Organization Code is required.',
            'name.required_if' => 'Name is required.',
            'email.required_if' => 'Email is required.',
            'password.required_if' => 'Password is required.',
        ];
    }
}
