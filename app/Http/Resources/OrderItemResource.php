<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'product' => [
                'code' => $this->product?->code,
                'name' => $this->product?->name,
                'sku' => $this->product?->sku,
            ],
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'discount' => $this->discount,
            'subtotal' => $this->subtotal,
        ];
    }
}
