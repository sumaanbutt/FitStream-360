<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'present_today' => $this['present_today'],
            'absent_today'  => $this['absent_today'],
            'late_today'    => $this['late_today'],
        ];
    }
}
