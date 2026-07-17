<?php

namespace App\Http\Requests\DietPlanWeek;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDietPlanWeekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'week_number' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'title' => [
                'sometimes',
                'nullable',
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

            'instructions' => [
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
