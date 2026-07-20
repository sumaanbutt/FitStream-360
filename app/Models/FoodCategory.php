<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodCategory extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'created_by',
        'name',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'code'
        );
    }

    public function foods(): HasMany
    {
        return $this->hasMany(
            Food::class,
            'food_category_code',
            'code'
        );
    }
}
