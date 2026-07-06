<?php

namespace App\Http\Requests\TraineeGoalsAttachments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeGoalAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trainee_goal_code' => ['required', 'exists:trainee_goals,code',],
            'attachment_type' => ['required',
                Rule::in([
                    'image',
                    'video',
                    'pdf',
                    'document',
                ]),
            ],

            'file_name' => ['nullable', 'string',],
            'file' => ['required', 'file', 'max:20480', 'mimes:jpg,jpeg,png,mp4,mov,avi,pdf,doc,docx',],
            'description' => ['nullable', 'string',],
        ];
    }

    public function messages(): array
    {
        return [
            'trainee_goal_code.required' => 'Please select a trainee goal.',
            'trainee_goal_code.exists' => 'Selected trainee goal does not exist.',
            'file.required' => 'Please upload a file.',
        ];
    }
}
