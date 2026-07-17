<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'code' => $this->code,

            'organization' => [
                'code' => $this->organization?->code,
                'name' => $this->organization?->name,
            ],

            'created_by' => [
                'code' => $this->creator?->code,
                'name' => $this->creator?->name,
            ],

            'title' => $this->title,

            'description' => $this->description,

            'goal' => $this->goal,

            'level' => $this->level,

            'gender' => $this->gender,

            'duration_weeks' => $this->duration_weeks,

            'days_per_week' => $this->days_per_week,

            'estimated_minutes_per_day' => $this->estimated_minutes_per_day,

            'requires_gym' => $this->requires_gym,

            'price' => $this->price,

            'currency' => $this->currency,

            'cover_image' => $this->cover_image_path,

            'status' => $this->status,

            'weeks_count' => $this->whenCounted('weeks'),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
