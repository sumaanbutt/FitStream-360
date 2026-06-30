<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TraineeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'code' => $this->code,

            'business' => [
                'code' => $this->business?->code,
                'name' => $this->business?->name,
            ],

            'user' => [
                'code' => $this->user?->code,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
                'phone' => $this->user?->phone,
                'role' => $this->user?->getRoleNames()->first(),
            ],

            'gender' => $this->gender,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,

            'joining_date' => optional($this->joining_date)
                ->format('Y-m-d'),

            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
