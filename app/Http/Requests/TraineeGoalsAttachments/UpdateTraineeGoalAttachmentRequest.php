<?php

namespace App\Http\Requests\TraineeGoalsAttachments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTraineeGoalAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachment_type' => ['sometimes',
                Rule::in([
                    'image',
                    'video',
                    'pdf',
                    'document',
                ]),
            ],

            'file' => ['nullable', 'file', 'max:20480', 'mimes:jpg,jpeg,png,mp4,mov,avi,pdf,doc,docx',],
            'description' => ['nullable', 'string',],
        ];
    }

    public function messages(): array
    {
        return [
            'file.file' => 'Please upload a valid file.',
        ];
    }
}
