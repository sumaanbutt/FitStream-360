<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'organization_code',
        'code',
        'name',
        'email',
        'phone',
        'discount_percentage',
        'agreement_start',
        'agreement_end',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'agreement_start' => 'date',
            'agreement_end' => 'date',
            'status' => 'boolean',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
