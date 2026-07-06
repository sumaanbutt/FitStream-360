<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{
    protected $fillable = [
        'code',
        'title',
        'diet_type',
        'duration',
        'duration_uom',
        'calories',
        'image',
        'pdf_file',
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
