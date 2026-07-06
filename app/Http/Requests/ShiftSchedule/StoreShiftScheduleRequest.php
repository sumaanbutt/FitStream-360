<?php

namespace App\Http\Requests\ShiftSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShiftScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_code' => ['required', 'exists:organizations,code',],
            'staff_code' => ['required', 'exists:staff,code',],
            'working_day' => ['required',
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

            'start_time' => ['required', 'date_format:H:i',],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time',],

            'status' => ['sometimes',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }
}
