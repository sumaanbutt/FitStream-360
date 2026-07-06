<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'organization' => [
                'code' => $this->organization?->code,
                'name' => $this->organization?->name,
            ],
            'business' => [
                'code' => $this->business?->code,
                'name' => $this->business?->name,
            ],

            'user' => $this->when(
                $this->user,
                [
                    'code' => $this->user?->code,
                    'name' => $this->user?->name,
                ]

            ),
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'status' => $this->status,

//            'items' => OrderItemResource::collection(
//                $this->whenLoaded('items')
//            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
