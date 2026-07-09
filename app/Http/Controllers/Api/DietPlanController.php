<?php

namespace App\Http\Controllers\Api;

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

    #[Authorize('viewAny', DietPlan::class)]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            DietPlanResource::collection(
                $this->dietPlanService->index()
            ),
            'Diet plans fetched successfully.'
        );
    }

    #[Authorize('create', DietPlan::class)]
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

    #[Authorize('view', DietPlan::class)]
    public function show(DietPlan $dietPlan): JsonResponse
    {
        return ApiResponse::success(
            new DietPlanResource($dietPlan),
            'Diet plan fetched successfully.'
        );
    }

    #[Authorize('update', DietPlan::class)]
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

    #[Authorize('delete', DietPlan::class)]
    public function destroy(DietPlan $dietPlan): JsonResponse
    {
        $this->dietPlanService->destroy($dietPlan);

        return ApiResponse::success(
            null,
            'Diet plan deleted successfully.'
        );
    }
}
