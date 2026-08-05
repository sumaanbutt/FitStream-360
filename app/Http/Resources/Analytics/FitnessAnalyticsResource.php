<?php

namespace App\Http\Resources\Analytics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FitnessAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_workout_plans' => $this['total_workout_plans'],
            'total_diet_plans'    => $this['total_diet_plans'],
            'total_equipment'     => $this['total_equipment'],
            'total_exercises'     => $this['total_exercises'],
        ];
    }
}
