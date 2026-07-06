<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    protected $fillable = [
        'code',
        'title',
        'workout_type',
        'duration',
        'duration_uom',
        'image',
        'pdf_file',
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
