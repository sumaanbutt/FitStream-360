<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DietPlan\StoreDietPlanRequest;
use App\Http\Requests\DietPlan\UpdateDietPlanRequest;
use App\Http\Resources\DietPlanResource;
use App\Models\DietPlan;
use App\Services\DietPlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class DietPlanController extends Controller
{
    public function __construct(
        protected DietPlanService $dietPlanService
    ) {}

    #[Permission(['can-view-dietplan'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            DietPlanResource::collection(
                $this->dietPlanService->index()
            ),
            'Diet plans fetched successfully.'
        );
    }

    #[Permission(['can-create-staff'])]
    public function store(StoreDietPlanRequest $request): JsonResponse
    {
        $dietPlan = $this->dietPlanService->store(
            $request->validated(),
            $request->file('image'),
            $request->file('pdf_file')
        );

        return ApiResponse::success(
            new DietPlanResource($dietPlan),
            'Diet plan created successfully.',
            201
        );
    }

    #[Permission(['can-view-dietplan'])]
    public function show(DietPlan $dietPlan): JsonResponse
    {
        return ApiResponse::success(
            new DietPlanResource($dietPlan),
            'Diet plan fetched successfully.'
        );
    }

    #[Permission(['can-update-dietplan'])]
    public function update(UpdateDietPlanRequest $request, DietPlan $dietPlan): JsonResponse {

        $dietPlan = $this->dietPlanService->update(
            $dietPlan,
            $request->validated(),
            $request->file('image'),
            $request->file('pdf_file')
        );

        return ApiResponse::success(
            new DietPlanResource($dietPlan),
            'Diet plan updated successfully.'
        );
    }

    #[Permission(['can-deactivate-dietplan'])]
    public function destroy(DietPlan $dietPlan): JsonResponse
    {
        $this->dietPlanService->destroy($dietPlan);

        return ApiResponse::success(
            null,
            'Diet plan deleted successfully.'
        );
    }
}
