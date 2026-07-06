<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TraineeGoalAttachmentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'code' => $this->code,
            'attachment_type' => $this->attachment_type,
            'file_name' => $this->file_name,
            'file' => $this->file_path,
            'description' => $this->description,

            'uploaded_at' => optional($this->uploaded_at)
                ->format('Y-m-d H:i:s'),

            'uploaded_by' => [
                'code' => $this->uploader?->code,
                'name' => $this->uploader?->name,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
