<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DietPlanMeal\StoreDietPlanMealRequest;
use App\Http\Requests\DietPlanMeal\UpdateDietPlanMealRequest;
use App\Http\Resources\DietPlanMealResource;
use App\Models\DietPlanMeal;
use App\Services\DietPlanMealService;
use Illuminate\Http\JsonResponse;

class DietPlanMealController extends Controller
{
    public function __construct(
        protected DietPlanMealService $dietPlanMealService
    ) {}

    #[Permission(['can-view-dietplan-meals'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            DietPlanMealResource::collection(
                $this->dietPlanMealService->index()
            ),
            'Diet plan meals fetched successfully.'
        );
    }

    #[Permission(['can-create-dietplan-meals'])]
    public function store(StoreDietPlanMealRequest $request): JsonResponse
    {
        $meal = $this->dietPlanMealService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanMealResource($meal),
            'Diet plan meal created successfully.',
            201
        );
    }

    #[Permission(['can-view-dietplan-meals'])]
    public function show(DietPlanMeal $dietPlanMeal): JsonResponse
    {
        return ApiResponse::success(
            new DietPlanMealResource($dietPlanMeal),
            'Diet plan meal fetched successfully.'
        );
    }

    #[Permission(['can-update-dietplan-meals'])]
    public function update(UpdateDietPlanMealRequest $request, DietPlanMeal $dietPlanMeal): JsonResponse
    {
        $meal = $this->dietPlanMealService->update(
            $dietPlanMeal,
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanMealResource($meal),
            'Diet plan meal updated successfully.'
        );
    }

    #[Permission(['can-deactivate-dietplan-meals'])]
    public function destroy(DietPlanMeal $dietPlanMeal): JsonResponse
    {
        $this->dietPlanMealService->destroy(
            $dietPlanMeal
        );

        return ApiResponse::success(
            null,
            'Diet plan meal deleted successfully.'
        );
    }
}
