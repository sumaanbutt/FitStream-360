<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_users'     => $this['total_users'],
            'total_staff'     => $this['total_staff'],
            'total_trainers'  => $this['total_trainers'],
            'total_trainees'  => $this['total_trainees'],
            'active_users'    => $this['active_users'],
            'inactive_users'  => $this['inactive_users'],
        ];
    }
}
