<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TraineeGoalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'code' => $this->code,

            'organization' => [
                'code' => $this->organization?->code,
                'name' => $this->organization?->name,
            ],

            'trainee' => [
                'code' => $this->trainee?->code,
                'name' => $this->trainee?->user?->name,
            ],

            'created_by' => [
                'code' => $this->creator?->code,
                'name' => $this->creator?->name,
            ],

            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'target_weight' => $this->target_weight,
            'target_body_fat' => $this->target_body_fat,
            'start_date' => $this->start_date,
            'target_date' => $this->target_date,
            'goal_source' => $this->goal_source,
            'category' => $this->category,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
