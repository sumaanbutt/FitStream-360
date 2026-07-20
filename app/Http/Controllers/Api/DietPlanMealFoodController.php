<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DietPlanMealFood\StoreDietPlanMealFoodRequest;
use App\Http\Requests\DietPlanMealFood\UpdateDietPlanMealFoodRequest;
use App\Http\Resources\DietPlanMealFoodResource;
use App\Models\DietPlanMealFood;
use App\Services\DietPlanMealFoodService;
use Illuminate\Http\JsonResponse;

class DietPlanMealFoodController extends Controller
{
    public function __construct(
        protected DietPlanMealFoodService $dietPlanMealFoodService
    ) {}

    #[Permission(['can-view-dietplan-meal-foods'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            DietPlanMealFoodResource::collection(
                $this->dietPlanMealFoodService->index()
            ),
            'Diet plan meal foods fetched successfully.'
        );
    }

    #[Permission(['can-create-dietplan-meal-foods'])]
    public function store(StoreDietPlanMealFoodRequest $request): JsonResponse
    {
        $mealFood = $this->dietPlanMealFoodService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanMealFoodResource($mealFood),
            'Diet plan meal food created successfully.',
            201
        );
    }

    #[Permission(['can-view-dietplan-meal-foods'])]
    public function show(DietPlanMealFood $dietPlanMealFood): JsonResponse
    {
        return ApiResponse::success(
            new DietPlanMealFoodResource($dietPlanMealFood),
            'Diet plan meal food fetched successfully.'
        );
    }

    #[Permission(['can-update-dietplan-meal-foods'])]
    public function update(UpdateDietPlanMealFoodRequest $request, DietPlanMealFood $dietPlanMealFood): JsonResponse
    {
        $mealFood = $this->dietPlanMealFoodService->update(
            $dietPlanMealFood,
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanMealFoodResource($mealFood),
            'Diet plan meal food updated successfully.'
        );
    }

    #[Permission(['can-deactivate-dietplan-meal-foods'])]
    public function destroy(DietPlanMealFood $dietPlanMealFood): JsonResponse
    {
        $this->dietPlanMealFoodService->destroy(
            $dietPlanMealFood
        );

        return ApiResponse::success(
            null,
            'Diet plan meal food deleted successfully.'
        );
    }
}
