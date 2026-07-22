<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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

            'staff_type' => $this->staff_type,
            'salary' => $this->salary,
            'cnic' => $this->cnic,
            'blood_group' => $this->blood_group,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,

            'joining_date' => optional($this->joining_date)
                ->format('Y-m-d'),

            'trainer' => TrainerResource::make(
                $this->whenLoaded('trainer')
            ),

            'status' => $this->status,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
