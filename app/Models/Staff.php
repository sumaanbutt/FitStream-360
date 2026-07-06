<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Staff extends Model
{
    protected $fillable = [
        'code',
        'business_code',
        'user_code',
//      'staff_type',
        'salary',
        'certifications',
        'experience',
        'joining_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'salary' => 'decimal:2',
            'joining_date' => 'date',
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

    public function business(): BelongsTo
    {
        return $this->belongsTo(
            Business::class,
            'business_code',
            'code'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_code',
            'code'
        );
    }

    public function locations()
    {
        return $this->hasMany(
            Location::class,
            'staff_code',
            'code'
        );
    }

    public function shiftSchedules()
    {
        return $this->hasMany(
            ShiftSchedule::class,
            'staff_code',
            'code'
        );
    }



// Future Relationships:

//    public function trainer(): HasOne
//    {
//        return $this->hasOne(
//            Trainer::class,
//            'staff_code',
//            'code'
//        );
//    }

}
