<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,

            'business'=> [
                'code' => $this->business?->code,
                'name' => $this->business?->name,
            ],

            'category' => [
                'code' => $this->category?->code,
                'name' => $this->category?->name,
            ],

            'sub_category' => [
                'code' => $this->subcategory?->code,
                'name' => $this->subcategory?->name,
            ],

            'product_name' => $this->product_name,
            'product_description' => $this->product_description,
            'sku' => $this->sku,
            'product_price' => $this->product_price,
            'quantity' => $this->quantity,
            'image' => $this->product_image_path,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
