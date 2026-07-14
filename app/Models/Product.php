<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'code',
        'organization_code',
        'category_code',
        'subcategory_code',
        'product_name',
        'product_description',
        'product_price',
        'product_image_path',
        'sku',
        'quantity',
//        'status',
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_code',
            'code'
        );
    }

    public function subcategory()
    {
        return $this->belongsTo(
            SubCategory::class,
            'subcategory_code',
            'code'
        );
    }

    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class,
            'product_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
