<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DietPlanDay\StoreDietPlanDayRequest;
use App\Http\Requests\DietPlanDay\UpdateDietPlanDayRequest;
use App\Http\Resources\DietPlanDayResource;
use App\Models\DietPlanDay;
use App\Services\DietPlanDayService;
use Illuminate\Http\JsonResponse;

class DietPlanDayController extends Controller
{
    public function __construct(
        protected DietPlanDayService $dietPlanDayService
    ) {}

    #[Permission(['can-view-dietplan'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            DietPlanDayResource::collection(
                $this->dietPlanDayService->index()
            ),
            'Diet days fetched successfully.'
        );
    }

    #[Permission(['can-create-dietplan'])]
    public function store(StoreDietPlanDayRequest $request): JsonResponse
    {
        $day = $this->dietPlanDayService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanDayResource($day),
            'Diet day created successfully.',
            201
        );
    }

    #[Permission(['can-view-dietplan'])]
    public function show(DietPlanDay $dietPlanDay): JsonResponse
    {
        return ApiResponse::success(
            new DietPlanDayResource($dietPlanDay),
            'Diet day fetched successfully.'
        );
    }

    #[Permission(['can-update-dietplan'])]
    public function update(UpdateDietPlanDayRequest $request, DietPlanDay $dietPlanDay): JsonResponse
    {
        $day = $this->dietPlanDayService->update(
            $dietPlanDay,
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanDayResource($day),
            'Diet day updated successfully.'
        );
    }

    #[Permission(['can-deactivate-dietplan'])]
    public function destroy(DietPlanDay $dietPlanDay): JsonResponse
    {
        $this->dietPlanDayService->destroy($dietPlanDay);

        return ApiResponse::success(
            null,
            'Diet day deleted successfully.'
        );
    }
}
