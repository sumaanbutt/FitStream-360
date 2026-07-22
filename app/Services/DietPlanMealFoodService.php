<?php

namespace App\Services;

use App\Models\DietPlanMeal;
use App\Models\DietPlanMealFood;
use App\Models\Food;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DietPlanMealFoodService
{
    use HasCode;

    public function index()
    {
        return DietPlanMealFood::with([
            'dietPlanMeal',
            'food',
        ])
            ->paginate(10);
    }

    public function store(array $data): DietPlanMealFood
    {
        try {
            return DB::transaction(function () use ($data) {

                $meal = DietPlanMeal::where(
                    'code',
                    $data['diet_plan_meal_code']
                )->firstOrFail();

                $food = Food::where(
                    'code',
                    $data['food_code']
                )->firstOrFail();

                if (
                    $meal->dietPlan->organization_code !==
                    $food->organization_code
                ) {
                    throw ValidationException::withMessages([
                        'food_code' => [
                            'The selected food does not belong to the same organization.'
                        ],
                    ]);
                }

                $exists = DietPlanMealFood::where(
                    'diet_plan_meal_code',
                    $data['diet_plan_meal_code']
                )
                    ->where(
                        'food_code',
                        $data['food_code']
                    )
                    ->exists();

                if ($exists) {

                    throw ValidationException::withMessages([
                        'food_code' => [
                            'This food has already been added to the selected meal.'
                        ],
                    ]);
                }

                $mealFood = DietPlanMealFood::create([
                    'code' => $this->generateCode('DMF', DietPlanMealFood::class),
                    'diet_plan_meal_code' => $data['diet_plan_meal_code'],
                    'food_code' => $data['food_code'],
                    'quantity' => $data['quantity'],
                    'unit' => $data['unit'],
                    'calories' => $data['calories'] ?? null,
                    'protein' => $data['protein'] ?? null,
                    'carbohydrates' => $data['carbohydrates'] ?? null,
                    'fat' => $data['fat'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ]);

                return $mealFood->load([
                    'dietPlanMeal',
                    'food',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Meal Food Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(DietPlanMealFood $dietPlanMealFood, array $data): DietPlanMealFood
    {
        try {
            return DB::transaction(function () use (
                $dietPlanMealFood,
                $data
            ) {

                $dietPlanMealFood->update([
                    'quantity' => $data['quantity'] ?? $dietPlanMealFood->quantity,
                    'unit' => $data['unit'] ?? $dietPlanMealFood->unit,
                    'calories' => $data['calories'] ?? $dietPlanMealFood->calories,
                    'protein' => $data['protein'] ?? $dietPlanMealFood->protein,
                    'carbohydrates' => $data['carbohydrates'] ?? $dietPlanMealFood->carbohydrates,
                    'fat' => $data['fat'] ?? $dietPlanMealFood->fat,
                    'notes' => $data['notes'] ?? $dietPlanMealFood->notes,
                ]);

                return $dietPlanMealFood
                    ->fresh()
                    ->load([
                        'dietPlanMeal',
                        'food',
                    ]);
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Meal Food Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(DietPlanMealFood $dietPlanMealFood): bool
    {
        try {
            return DB::transaction(function () use ($dietPlanMealFood) {

                $dietPlanMealFood->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Meal Food Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
