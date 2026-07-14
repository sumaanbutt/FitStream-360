<?php

namespace App\Models;

use App\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasApiFilters;

    protected $fillable = [
        'code',
        'name',
        'address',
        'logo',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function businesses(): HasMany
    {
        return $this->hasMany(
            Business::class,
            'organization_code',
            'code'
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(
            User::class,
            'organization_code',
            'code'
        );
    }

    public function shiftSchedules()
    {
        return $this->hasMany(
            ShiftSchedule::class,
            'organization_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    protected array $filterable = [
        'code',
        'status',
        'search',
    ];

    protected array $sortable = [
        'name',
        'created_at',
        'updated_at',
    ];

    protected function filterSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {

            $q->where('name', 'like', "%{$value}%")
                ->orWhere('email', 'like', "%{$value}%")
                ->orWhere('phone', 'like', "%{$value}%")
                ->orWhere('code', 'like', "%{$value}%");

        });
    }
}
