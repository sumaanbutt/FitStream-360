<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TraineeGoalProgressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'trainee_goal_code' => $this->trainee_goal_code,
            'weight' => $this->weight,
            'body_fat' => $this->body_fat,
            'muscle_mass' => $this->muscle_mass,
            'chest' => $this->chest,
            'waist' => $this->waist,
            'hips' => $this->hips,
            'arms' => $this->arms,
            'thighs' => $this->thighs,
            'progress_percentage' => $this->progress_percentage,
            'notes' => $this->notes,
            'recorded_at' => $this->recorded_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'goal' => new TraineeGoalResource(
                $this->whenLoaded('goal')
            ),
        ];    }
}
