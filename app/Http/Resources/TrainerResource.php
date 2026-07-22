<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'experience' => $this->experience,
            'certifications' => $this->certifications,
            'specialization' => $this->specialization,
            'bio' => $this->bio,
            'status' => $this->status,
        ];
    }
}
