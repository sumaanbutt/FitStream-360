<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TraineeGoalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'trainee' => [
                'code' => $this->trainee?->code,
                'name' => $this->trainee?->user?->name,
                'email' => $this->trainee?->user?->email,
            ],

            'title' => $this->title,
            'description' => $this->description,
            'target_value' => $this->target_value,
            'target_unit' => $this->target_unit,

            'start_date' => optional($this->start_date)
                ->format('Y-m-d'),

            'target_date' => optional($this->target_date)
                ->format('Y-m-d'),

            'status' => $this->status,
            'remarks' => $this->remarks,

            'attachments' => TraineeGoalAttachmentsResource::collection(
                $this->whenLoaded('attachments')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
