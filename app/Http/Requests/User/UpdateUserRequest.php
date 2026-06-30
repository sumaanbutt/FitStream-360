<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','email'],
            'phone' => ['sometimes','string','max:20'],
            'password' => ['sometimes','confirmed','min:8'],
            'status' => ['sometimes','boolean'],
            'role' => ['sometimes','exists:roles,name'],
        ];
    }
}
