<?php

namespace App\Http\Requests\Business;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
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
            'name' => ['sometimes','required','string','max:255'],
            'email' => ['sometimes','required','email'],
            'phone' => ['nullable','string'],
            'discount_percentage' => ['sometimes','numeric','min:0','max:100'],
            'agreement_start' => ['sometimes','date'],
            'agreement_end' => ['sometimes','date'],
            'status' => ['sometimes','boolean'],
        ];
    }
}
