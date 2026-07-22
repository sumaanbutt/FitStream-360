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
            'trainee_type' => $this->trainee_type,

            'organization' => [
                'code' => $this->organization?->code,
                'name' => $this->organization?->name,
            ],

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

// it didn't seem right as when we choose trainee_type as business,
// we require both business_code and organization_code,
// business_code of trainee which he is going to be the member of and organization_code is of that business
// and if choose organization as trainee_type then no need to give business_code, just need to add organization_code,
// which the trainee belongs to,
// and one more confusion is in both staff and trainee as there basic info like name, email, phone comes from user_code,
