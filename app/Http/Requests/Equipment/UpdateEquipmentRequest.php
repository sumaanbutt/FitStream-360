<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255',],
            'description' => ['sometimes', 'nullable', 'string',],

            'category' => [
                'sometimes',
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

            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',],
            'status' => ['sometimes', 'boolean',],
        ];
    }
}
