<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'code' => $this->code,
            'business' => [
                'code' => $this->business?->code,
                'name' => $this->business?->name,
            ],

            'staff' => $this->when(
                $this->staff,
                [
                    'code' => $this->staff?->code,
                    'name' => $this->staff?->user?->name,
                ]
            ),

            'location_type' => $this->location_type,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
