<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required', 'exists:organizations,code',],
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],

            'category' => [
                'required',
                Rule::in([
                    'strength',
                    'cardio',
                    'functional',
                    'free_weight',
                    'machine',
                    'accessory',
                    'other',
                ]),
            ],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
