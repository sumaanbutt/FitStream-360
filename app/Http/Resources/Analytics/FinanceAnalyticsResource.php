<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinanceAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_profit' => $this['total_profit'],
            'total_loss'   => $this['total_loss'],
            'chart'        => $this['chart'],
        ];
    }
}
