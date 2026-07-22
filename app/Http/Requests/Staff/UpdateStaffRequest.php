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

            'phone' => ['sometimes','nullable', 'string', 'max:20',],
            'password' => ['sometimes','nullable', 'string', 'min:8', 'confirmed',],

// Staff Information:
            'role' => [
                'sometimes',
                Rule::exists('roles', 'name')->where(
                    fn ($query) => $query->where('guard_name', 'api')
                ),
            ],




//          'business_code' => ['sometimes', 'exists:businesses,code',],

            'cnic' => ['sometimes','nullable', 'string', 'max:20',],

            'blood_group' => [
                'nullable',
                Rule::in([
                    'A+','A-', 'B+','B-', 'AB+','AB-', 'O+','O-',
                ]),
            ],

            'emergency_contact_name' => ['nullable', 'string', 'max:255',],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20',],
            'salary' => ['sometimes', 'numeric', 'min:0',],
            'joining_date' => ['sometimes', 'date',],
            'status' => ['sometimes', 'boolean',],


// Trainer Information:

            'experience' => [
                Rule::requiredIf(
                    fn () => strtolower($this->input('role', '')) === 'trainer'
                ),
                'nullable', 'string',],

            'certifications' => [
                Rule::requiredIf(
                    fn () => strtolower($this->input('role', '')) === 'trainer'
                ),
                'nullable', 'string',],

            'specialization' => [
                Rule::requiredIf(
                    fn () => strtolower($this->input('role', '')) === 'trainer'
                ),
                'nullable', 'string',],

            'bio' => ['sometimes', 'nullable', 'string',],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already taken.',
            'business_code.exists' => 'Selected business does not exist.',
            'organization_code.exists' => 'Selected organization does not exist.',

            'experience.required' => 'Experience is required for trainers.',
            'certifications.required' => 'Certifications are required for trainers.',
            'specialization.required' => 'Specialization is required for trainers.',
        ];
    }
}
