<?php

namespace App\Http\Requests\Business;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
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
            'organization_code' => ['required','exists:organizations,code'],
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:businesses,email'],
            'phone' => ['nullable','string','max:20'],
            'discount_percentage' => ['required','numeric','min:0','max:100'],
            'agreement_start' => ['required','date'],
            'agreement_end' => ['required','date',],
            'status' => ['required','boolean'],

            // Business Admin

            'admin_name' => ['required','string','max:255'],
            'admin_email' => ['required','email','unique:users,email'],
            'admin_phone' => ['nullable','string','max:20'],
            'admin_password' => ['required','confirmed','min:8'],
        ];
    }
}
