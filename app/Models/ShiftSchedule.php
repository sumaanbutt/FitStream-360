<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    protected $fillable = [
        'code',
        'organization_code',
        'staff_code',
        'working_day',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'organization_code',
            'code'
        );
    }

    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'staff_code',
            'code'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
