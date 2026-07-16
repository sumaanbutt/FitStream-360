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

            'gym_goal' => [
                'code' => $this->gymGoal?->code,
                'title' => $this->gymGoal?->title,
                'category' => $this->gymGoal?->goal_category,
            ],

            'title' => $this->title,
            'description' => $this->description,

            'priority' => $this->priority,
            'target_weight' => $this->target_weight,
            'target_body_fat' => $this->target_body_fat,

            'start_date' => optional($this->start_date)
                ->format('Y-m-d'),

            'target_date' => optional($this->target_date)
                ->format('Y-m-d'),

            'status' => $this->status,
            'notes' => $this->remarks,

            'attachments' => TraineeGoalAttachmentsResource::collection(
                $this->whenLoaded('attachments')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
