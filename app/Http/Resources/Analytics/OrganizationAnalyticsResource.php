<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_organizations' => $this['total_organizations'],
            'total_businesses'    => $this['total_businesses'],
            'total_locations'     => $this['total_locations'],
            'total_roles'         => $this['total_roles'],
            'total_permissions'   => $this['total_permissions'],
        ];
    }
}
