<?php

namespace App\Http\Requests\DietPlanDay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDietPlanDayRequest extends FormRequest
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

            'diet_plan_week_code' => [
                'required',
                'exists:diet_plan_weeks,code',
            ],

            'day_number' => [
                'required',
                'integer',
                'between:1,7',
            ],

            'day_name' => [
                'required',
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
                'required',
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

            'water_target_liters' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
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
