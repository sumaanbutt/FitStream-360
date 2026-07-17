<?php

namespace App\Services;

use App\Models\DietPlanDay;
use App\Models\DietPlanWeek;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DietPlanDayService
{
    use HasCode;

    public function index()
    {
        return DietPlanDay::with([
            'dietPlan',
            'dietPlanWeek',
        ]);
    }

    public function store(array $data): DietPlanDay
    {
        try {
            return DB::transaction(function () use ($data) {

                $week = DietPlanWeek::where(
                    'code',
                    $data['diet_plan_week_code']
                )
                    ->where(
                        'diet_plan_code',
                        $data['diet_plan_code']
                    )
                    ->first();

                if (! $week) {

                    throw ValidationException::withMessages([
                        'diet_plan_week_code' => [
                            'The selected diet plan week does not belong to the selected diet plan.'
                        ],
                    ]);
                }

                $exists = DietPlanDay::where(
                    'diet_plan_week_code',
                    $data['diet_plan_week_code']
                )
                    ->where(
                        'day_number',
                        $data['day_number']
                    )
                    ->exists();

                if ($exists) {

                    throw ValidationException::withMessages([
                        'day_number' => [
                            'This day already exists in the selected week.'
                        ],
                    ]);
                }

                $dietPlanDay = DietPlanDay::create([
                    'code' => $this->generateCode('DPD', DietPlanDay::class),
                    'diet_plan_code' => $data['diet_plan_code'],
                    'diet_plan_week_code' => $data['diet_plan_week_code'],
                    'day_number' => $data['day_number'],
                    'day_name' => $data['day_name'],
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'target_calories' => $data['target_calories'] ?? null,
                    'target_protein' => $data['target_protein'] ?? null,
                    'target_carbohydrates' => $data['target_carbohydrates'] ?? null,
                    'target_fat' => $data['target_fat'] ?? null,
                    'water_target_liters' => $data['water_target_liters'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'status' => $data['status'] ?? 'active',
                ]);

                return $dietPlanDay->load([
                    'dietPlan',
                    'dietPlanWeek',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Day Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(DietPlanDay $dietPlanDay, array $data): DietPlanDay
    {
        try {
            return DB::transaction(function () use (
                $dietPlanDay,
                $data
            ) {

                if (
                    isset($data['day_number']) &&
                    $data['day_number'] != $dietPlanDay->day_number
                ) {

                    $exists = DietPlanDay::where(
                        'diet_plan_week_code',
                        $dietPlanDay->diet_plan_week_code
                    )
                        ->where(
                            'day_number',
                            $data['day_number']
                        )
                        ->where(
                            'code',
                            '!=',
                            $dietPlanDay->code
                        )
                        ->exists();

                    if ($exists) {

                        throw ValidationException::withMessages([
                            'day_number' => [
                                'This day already exists in the selected week.'
                            ],
                        ]);
                    }
                }

                $updateData = [
                    'day_number' => $data['day_number'] ?? $dietPlanDay->day_number,
                    'day_name' => $data['day_name'] ?? $dietPlanDay->day_name,
                    'title' => $data['title'] ?? $dietPlanDay->title,
                    'description' => $data['description'] ?? $dietPlanDay->description,
                    'target_calories' => $data['target_calories'] ?? $dietPlanDay->target_calories,
                    'target_protein' => $data['target_protein'] ?? $dietPlanDay->target_protein,
                    'target_carbohydrates' => $data['target_carbohydrates'] ?? $dietPlanDay->target_carbohydrates,
                    'target_fat' => $data['target_fat'] ?? $dietPlanDay->target_fat,
                    'water_target_liters' => $data['water_target_liters'] ?? $dietPlanDay->water_target_liters,
                    'notes' => $data['notes'] ?? $dietPlanDay->notes,
                    'status' => $data['status'] ?? $dietPlanDay->status,
                ];

                $dietPlanDay->update($updateData);

                return $dietPlanDay
                    ->fresh()
                    ->load([
                        'dietPlan',
                        'dietPlanWeek',
                    ]);
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Day Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(DietPlanDay $dietPlanDay): bool
    {
        try {
            return DB::transaction(function () use ($dietPlanDay) {

                $dietPlanDay->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Day Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
