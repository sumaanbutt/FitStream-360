<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required','exists:organizations,id'],
            'business_code' => ['nullable','exists:businesses,id'],
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['nullable','string','max:20'],
            'password' => ['required','confirmed','min:8'],
            'status' => ['required','boolean'],
            'role' => ['required','exists:roles,name'],
        ];
    }
}
