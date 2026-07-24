<?php

namespace App\Http\Requests\ShiftSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShiftScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_code' => ['sometimes', 'exists:staff,code',],
            'working_day' => ['sometimes',
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

            'start_time' => ['sometimes', 'date_format:H:i',],
            'end_time' => ['sometimes', 'date_format:H:i', 'after:start_time',],
            'status' => ['sometimes',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
