<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodCategory\StoreFoodCategoryRequest;
use App\Http\Requests\FoodCategory\UpdateFoodCategoryRequest;
use App\Http\Resources\FoodCategoryResource;
use App\Models\FoodCategory;
use App\Services\FoodCategoryService;
use Illuminate\Http\JsonResponse;

class FoodCategoryController extends Controller
{
    public function __construct(
        protected FoodCategoryService $foodCategoryService
    ) {}

    #[Permission(['can-view-food-categories'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            FoodCategoryResource::collection(
                $this->foodCategoryService->index()
            ),
            'Food categories fetched successfully.'
        );
    }

    #[Permission(['can-create-food-categories'])]
    public function store(StoreFoodCategoryRequest $request): JsonResponse
    {
        $foodCategory = $this->foodCategoryService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new FoodCategoryResource($foodCategory),
            'Food category created successfully.',
            201
        );
    }

    #[Permission(['can-view-food-categories'])]
    public function show(FoodCategory $foodCategory): JsonResponse
    {
        return ApiResponse::success(
            new FoodCategoryResource($foodCategory),
            'Food category fetched successfully.'
        );
    }

    #[Permission(['can-update-food-categories'])]
    public function update(UpdateFoodCategoryRequest $request, FoodCategory $foodCategory): JsonResponse
    {
        $foodCategory = $this->foodCategoryService->update(
            $foodCategory,
            $request->validated()
        );

        return ApiResponse::success(
            new FoodCategoryResource($foodCategory),
            'Food category updated successfully.'
        );
    }

    #[Permission(['can-deactivate-food-categories'])]
    public function destroy(FoodCategory $foodCategory): JsonResponse
    {
        $this->foodCategoryService->destroy(
            $foodCategory
        );

        return ApiResponse::success(
            null,
            'Food category deleted successfully.'
        );
    }
}
