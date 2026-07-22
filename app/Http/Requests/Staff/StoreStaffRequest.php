<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_type' => ['required', Rule::in(['existing', 'new'])],

// Existing User:
            'user_code' => ['required_if:user_type,existing', 'nullable', 'exists:users,code'],

// New User:
            'organization_code' => ['required_if:user_type,new', 'nullable', 'exists:organizations,code'],
            'name' => ['required_if:user_type,new', 'nullable', 'string', 'max:255'],
            'email' => ['required_if:user_type,new', 'nullable', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required_if:user_type,new', 'nullable', 'string', 'min:8', 'confirmed'],

// Staff Information:

            'business_code' => ['required', 'exists:businesses,code'],

            'role' => [
                'required',
                Rule::exists('roles', 'name')->where(function ($query) {
                    $query->where('guard_name', 'api');
                }),
            ],

            'salary' => ['required', 'numeric', 'min:0'],
            'joining_date' => ['required', 'date',],
            'cnic' => ['nullable', 'string', 'max:20',],

            'blood_group' => ['nullable',
                Rule::in([
                    'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-',
                ]),
            ],

            'emergency_contact_name' => ['nullable', 'string', 'max:255',],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20',],
            'status' => ['required', 'boolean'],



// Trainer Information:

            'experience' => [
                Rule::requiredIf(
                    fn () => strtolower($this->role ?? '') === 'trainer'
                ),
                'nullable', 'string',],

            'certifications' => [
                Rule::requiredIf(
                    fn () => strtolower($this->role ?? '') === 'trainer'
                ),
                'nullable', 'string',],

            'specialization' => [
                Rule::requiredIf(
                    fn () => strtolower($this->role ?? '') === 'trainer'
                ),
                'nullable', 'string',],

            'bio' => ['nullable', 'string',],
        ];
    }
    public function messages(): array
    {
        return [
            'user_type.required' => 'Please select user type.',
            'user_code.required_if' => 'User Code is required when selecting an existing user.',
            'organization_code.required_if' => 'Organization Code is required for a new user.',
            'name.required_if' => 'Name is required for a new user.',
            'email.required_if' => 'Email is required for a new user.',
            'password.required_if' => 'Password is required for a new user.',
            'business_code.required' => 'Business Code is required.',
            'role.required' => 'Please select a role.',

            'experience.required' => 'Experience is required for trainers.',
            'certifications.required' => 'Certifications are required for trainers.',
            'specialization.required' => 'Specialization is required for trainers.',
        ];
    }
}
