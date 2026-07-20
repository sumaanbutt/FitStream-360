<?php

namespace App\Services;

use App\Models\DietPlanDay;
use App\Models\DietPlanMeal;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DietPlanMealService
{
    use HasCode;

    public function index()
    {
        return DietPlanMeal::with([
            'dietPlan',
            'dietPlanWeek',
            'dietPlanDay',
        ])
            ->withCount('mealFoods');
    }

    public function store(array $data): DietPlanMeal
    {
        try {
            return DB::transaction(function () use ($data) {

                $day = DietPlanDay::where(
                    'code',
                    $data['diet_plan_day_code']
                )
                    ->where(
                        'diet_plan_code',
                        $data['diet_plan_code']
                    )
                    ->where(
                        'diet_plan_week_code',
                        $data['diet_plan_week_code']
                    )
                    ->first();

                if (! $day) {
                    throw ValidationException::withMessages([
                        'diet_plan_day_code' => [
                            'The selected day does not belong to the selected week and diet plan.'
                        ],
                    ]);
                }

                $exists = DietPlanMeal::where(
                    'diet_plan_day_code',
                    $data['diet_plan_day_code']
                )
                    ->where(
                        'meal_type',
                        $data['meal_type']
                    )
                    ->exists();

                if ($exists) {

                    throw ValidationException::withMessages([
                        'meal_type' => [
                            'This meal type already exists for the selected day.'
                        ],
                    ]);
                }

                $meal = DietPlanMeal::create([
                    'code' => $this->generateCode('DPM', DietPlanMeal::class),
                    'diet_plan_code' => $data['diet_plan_code'],
                    'diet_plan_week_code' => $data['diet_plan_week_code'],
                    'diet_plan_day_code' => $data['diet_plan_day_code'],
                    'meal_type' => $data['meal_type'],
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'recommended_time' => $data['recommended_time'] ?? null,
                    'estimated_calories' => $data['estimated_calories'] ?? null,
                    'protein' => $data['protein'] ?? null,
                    'carbohydrates' => $data['carbohydrates'] ?? null,
                    'fat' => $data['fat'] ?? null,
                    'servings' => $data['servings'],
                    'instructions' => $data['instructions'] ?? null,
                    'status' => $data['status'] ?? true,
                ]);

                return $meal->load([
                    'dietPlan',
                    'dietPlanWeek',
                    'dietPlanDay',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Meal Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(DietPlanMeal $dietPlanMeal, array $data): DietPlanMeal
    {
        try {
            return DB::transaction(function () use (
                $dietPlanMeal,
                $data
            ) {

                if (
                    isset($data['meal_type']) &&
                    $data['meal_type'] !== $dietPlanMeal->meal_type
                ) {

                    $exists = DietPlanMeal::where(
                        'diet_plan_day_code',
                        $dietPlanMeal->diet_plan_day_code
                    )
                        ->where(
                            'meal_type',
                            $data['meal_type']
                        )
                        ->where(
                            'code',
                            '!=',
                            $dietPlanMeal->code
                        )
                        ->exists();

                    if ($exists) {
                        throw ValidationException::withMessages([
                            'meal_type' => [
                                'This meal type already exists for the selected day.'
                            ],
                        ]);
                    }
                }

                $dietPlanMeal->update([
                    'meal_type' => $data['meal_type'] ?? $dietPlanMeal->meal_type,
                    'title' => $data['title'] ?? $dietPlanMeal->title,
                    'description' => $data['description'] ?? $dietPlanMeal->description,
                    'recommended_time' => $data['recommended_time'] ?? $dietPlanMeal->recommended_time,
                    'estimated_calories' => $data['estimated_calories'] ?? $dietPlanMeal->estimated_calories,
                    'protein' => $data['protein'] ?? $dietPlanMeal->protein,
                    'carbohydrates' => $data['carbohydrates'] ?? $dietPlanMeal->carbohydrates,
                    'fat' => $data['fat'] ?? $dietPlanMeal->fat,
                    'servings' => $data['servings'] ?? $dietPlanMeal->servings,
                    'instructions' => $data['instructions'] ?? $dietPlanMeal->instructions,
                    'status' => $data['status'] ?? $dietPlanMeal->status,
                ]);

                return $dietPlanMeal
                    ->fresh()
                    ->load([
                        'dietPlan',
                        'dietPlanWeek',
                        'dietPlanDay',
                    ]);

            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Meal Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(DietPlanMeal $dietPlanMeal): bool
    {
        try {
            return DB::transaction(function () use ($dietPlanMeal) {

                $dietPlanMeal->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Meal Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
