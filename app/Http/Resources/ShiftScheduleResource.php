<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'organization' => [
                'code' => $this->organization?->code,
                'name' => $this->organization?->name,
            ],

            'staff' => [
                'code' => $this->staff?->code,
                'name' => $this->staff?->user?->name,
            ],

            'working_day' => $this->working_day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
