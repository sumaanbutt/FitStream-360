<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DietPlanWeek\StoreDietPlanWeekRequest;
use App\Http\Requests\DietPlanWeek\UpdateDietPlanWeekRequest;
use App\Http\Resources\DietPlanWeekResource;
use App\Models\DietPlanWeek;
use App\Services\DietPlanWeekService;
use Illuminate\Http\JsonResponse;

class DietPlanWeekController extends Controller
{
    public function __construct(
        protected DietPlanWeekService $dietPlanWeekService
    ) {}

    #[Permission(['can-view-dietplan'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            DietPlanWeekResource::collection(
                $this->dietPlanWeekService->index()
            ),
            'Diet weeks fetched successfully.'
        );
    }

    #[Permission(['can-create-dietplan'])]
    public function store(StoreDietPlanWeekRequest $request): JsonResponse
    {
        $week = $this->dietPlanWeekService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanWeekResource($week),
            'Diet week created successfully.',
            201
        );
    }

    #[Permission(['can-view-dietplan'])]
    public function show(DietPlanWeek $dietPlanWeek): JsonResponse
    {
        return ApiResponse::success(
            new DietPlanWeekResource($dietPlanWeek),
            'Diet week fetched successfully.'
        );
    }

    #[Permission(['can-update-dietplan'])]
    public function update(UpdateDietPlanWeekRequest $request, DietPlanWeek $dietPlanWeek): JsonResponse
    {
        $week = $this->dietPlanWeekService->update(
            $dietPlanWeek,
            $request->validated()
        );

        return ApiResponse::success(
            new DietPlanWeekResource($week),
            'Diet week updated successfully.'
        );
    }

    #[Permission(['can-deactivate-dietplan'])]
    public function destroy(DietPlanWeek $dietPlanWeek): JsonResponse
    {
        $this->dietPlanWeekService->destroy($dietPlanWeek);

        return ApiResponse::success(
            null,
            'Diet week deleted successfully.'
        );
    }
}
