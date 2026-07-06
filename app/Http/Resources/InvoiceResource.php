<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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

            'user' => [
                'code' => $this->user?->code,
                'name' => $this->user?->name,
            ],

            'order_code' => $this->order_code,
            'invoice_type' => $this->invoice_type,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
