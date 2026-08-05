<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OverviewAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_organizations' => $this['total_organizations'],
            'total_businesses'    => $this['total_businesses'],
            'total_locations'     => $this['total_locations'],
            'total_users'         => $this['total_users'],
            'total_staff'         => $this['total_staff'],
            'total_trainees'      => $this['total_trainees'],
            'total_products'      => $this['total_products'],
            'total_orders'        => $this['total_orders'],
        ];
    }
}
