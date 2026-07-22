<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'organization' => $this->organization?->name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
//            'discount_percentage' => $this->discount_percentage,
//            'agreement_start' => $this->agreement_start,
//            'agreement_end' => $this->agreement_end,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
