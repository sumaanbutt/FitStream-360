<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_categories' => $this['total_categories'],
            'total_products'   => $this['total_products'],
        ];
    }
}
