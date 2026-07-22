<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanEquipment;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class WorkoutPlanEquipmentService
{
    use HasCode;

    public function index()
    {
        return WorkoutPlanEquipment::with([
            'workoutPlan',
            'equipment',
            ])
            ->paginate(10);
    }

    public function store(array $data): WorkoutPlanEquipment
    {
        try {
            return DB::transaction(function () use ($data) {

                $workoutPlan = WorkoutPlan::where(
                    'code',
                    $data['workout_plan_code']
                )->firstOrFail();

                $equipment = Equipment::where(
                    'code',
                    $data['equipment_code']
                )->firstOrFail();

                if (
                    $workoutPlan->organization_code !==
                    $equipment->organization_code
                ) {
                    throw ValidationException::withMessages([
                        'equipment_code' => [
                            'The selected equipment does not belong to the workout plan organization.'
                        ],
                    ]);
                }

                $exists = WorkoutPlanEquipment::where(
                    'workout_plan_code',
                    $data['workout_plan_code']
                )
                    ->where(
                        'equipment_code',
                        $data['equipment_code']
                    )
                    ->exists();

                if ($exists) {
                    throw ValidationException::withMessages([
                        'equipment_code' => [
                            'This equipment is already assigned to the workout plan.'
                        ],
                    ]);
                }

                $workoutPlanEquipment = WorkoutPlanEquipment::create([
                    'code' => $this->generateCode('WPE', WorkoutPlanEquipment::class),
                    'workout_plan_code' => $data['workout_plan_code'],
                    'equipment_code' => $data['equipment_code'],
                    'quantity' => $data['quantity'],
                    'is_required' => $data['is_required'] ?? true,
                    'notes' => $data['notes'] ?? null,
                ]);

                return $workoutPlanEquipment->load([
                    'workoutPlan',
                    'equipment',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Workout Plan Equipment Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(WorkoutPlanEquipment $workoutPlanEquipment, array $data): WorkoutPlanEquipment
    {
        try {
            return DB::transaction(function () use (
                $workoutPlanEquipment,
                $data
            ) {
                $workoutPlanEquipment->update([
                    'quantity' => $data['quantity'] ?? $workoutPlanEquipment->quantity,
                    'is_required' => $data['is_required'] ?? $workoutPlanEquipment->is_required,
                    'notes' => $data['notes'] ?? $workoutPlanEquipment->notes,
                ]);

                return $workoutPlanEquipment
                    ->fresh()
                    ->load([
                        'workoutPlan',
                        'equipment',
                    ]);
            });

        } catch (\Throwable $e) {
            Log::error('Workout Plan Equipment Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(WorkoutPlanEquipment $workoutPlanEquipment): bool
    {
        try {
            return DB::transaction(function () use (
                $workoutPlanEquipment
            ) {

                $workoutPlanEquipment->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Workout Plan Equipment Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
