<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_orders'      => $this['total_orders'],
            'pending_orders'    => $this['pending_orders'],
            'delivered_orders'  => $this['delivered_orders'],
        ];
    }
}
