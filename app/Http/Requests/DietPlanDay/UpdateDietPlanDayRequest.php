<?php

namespace App\Http\Requests\DietPlanDay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDietPlanDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'day_number' => [
                'sometimes',
                'integer',
                'between:1,7',
            ],

            'day_name' => [
                'sometimes',
                Rule::in([
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                ]),
            ],

            'title' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'target_calories' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
            ],

            'target_protein' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_carbohydrates' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_fat' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'water_target_liters' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'status' => [
                'sometimes',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
