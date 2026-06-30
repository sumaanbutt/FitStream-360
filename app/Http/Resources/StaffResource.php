<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'business' => ['code' => $this->business?->code, 'name' => $this->business?->name,],

            'user' => [
                'code' => $this->user?->code,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
                'phone' => $this->user?->phone,
                'role' => $this->user?->getRoleNames()->first(),
            ],

            'salary' => $this->salary,

            'joining_date' => optional($this->joining_date)
                ->format('Y-m-d'),

            'experience' => $this->experience,
            'certifications' => $this->certifications,
            'status' => $this->status,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
