<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'code' => $this->code,

            'organization' => $this->whenLoaded('organization'),
            'creator' => $this->whenLoaded('creator'),

            'title' => $this->title,
            'description' => $this->description,
            'diet_type' => $this->diet_type,
            'duration' => $this->duration,
            'duration_uom' => $this->duration_uom,
            'calories' => $this->calories,
            'image_path' => $this->image_path,
            'pdf_file_path' => $this->pdf_file_path,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
