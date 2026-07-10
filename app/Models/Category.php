<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=[
        'code',
        'organization_code',
        'name',
        'description',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

    public function subCategory()
    {
        return $this->hasMany(
            SubCategory::class,
            'category_code',
            'code'
        );
    }

    public function products()
    {
        return $this->hasMany(
            Product::class,
            'category_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
