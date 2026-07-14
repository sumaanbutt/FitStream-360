<?php

namespace App\Models;

use App\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasApiFilters;

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
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

    public function users()
    {
        return $this->hasMany(
            User::class,
            'business_code',
            'code'
        );
    }

    public function locations()
    {
        return $this->hasMany(
            Location::class,
            'business_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    protected array $filterable = [
        'code',
        'organization_code',
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
//        dd('filterSearch called');

        $query->where(function ($q) use ($value) {

            $q->where('code', 'like', "%{$value}%")
                ->orWhere('name', 'like', "%{$value}%")
                ->orWhere('email', 'like', "%{$value}%")
                ->orWhere('phone', 'like', "%{$value}%");

        });
    }
}
