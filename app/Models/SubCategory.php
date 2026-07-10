<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable=[
        'code',
        'category_code',
        'name',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_code',
            'code'
        );
    }

    public function products()
    {
        return $this->hasMany(
            Product::class,
            'subcategories_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
