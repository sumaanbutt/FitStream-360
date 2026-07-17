<?php

namespace App\Http\Requests\DietPlanWeek;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDietPlanWeekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'diet_plan_code' => [
                'required',
                'exists:diet_plans,code',
            ],

            'week_number' => [
                'required',
                'integer',
                'min:1',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'target_calories' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'target_protein' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_carbohydrates' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'target_fat' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'instructions' => [
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
