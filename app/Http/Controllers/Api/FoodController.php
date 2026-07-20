<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use App\Services\FoodService;
use Illuminate\Http\JsonResponse;

class FoodController extends Controller
{
    public function __construct(
        protected FoodService $foodService
    ) {}

    #[Permission(['can-view-foods'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            FoodResource::collection(
                $this->foodService->index()
            ),
            'Foods fetched successfully.'
        );
    }

    #[Permission(['can-create-foods'])]
    public function store(StoreFoodRequest $request): JsonResponse
    {
        $food = $this->foodService->store(
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new FoodResource($food),
            'Food created successfully.',
            201
        );
    }

    #[Permission(['can-view-foods'])]
    public function show(Food $food): JsonResponse
    {
        return ApiResponse::success(
            new FoodResource($food),
            'Food fetched successfully.'
        );
    }

    #[Permission(['can-update-foods'])]
    public function update(UpdateFoodRequest $request, Food $food): JsonResponse
    {
        $food = $this->foodService->update(
            $food,
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new FoodResource($food),
            'Food updated successfully.'
        );
    }

    #[Permission(['can-deactivate-foods'])]
    public function destroy(Food $food): JsonResponse
    {
        $this->foodService->destroy(
            $food
        );

        return ApiResponse::success(
            null,
            'Food deleted successfully.'
        );
    }
}
