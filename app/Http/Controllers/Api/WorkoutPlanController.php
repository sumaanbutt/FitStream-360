<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutPlan\StoreWorkoutPlanRequest;
use App\Http\Requests\WorkoutPlan\UpdateWorkoutPlanRequest;
use App\Http\Resources\WorkoutPlanResource;
use App\Models\WorkoutPlan;
use App\Services\WorkoutPlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class WorkoutPlanController extends Controller
{
    public function __construct(
        protected WorkoutPlanService $workoutPlanService
    ) {}

    #[Authorize('viewAny', WorkoutPlan::class)]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            WorkoutPlanResource::collection(
                $this->workoutPlanService->index()
            ),
            'Workout plans fetched successfully.'
        );
    }

    #[Authorize('create', WorkoutPlan::class)]
    public function store(StoreWorkoutPlanRequest $request): JsonResponse
    {
        $workoutPlan = $this->workoutPlanService->store(
            $request->validated(),
            $request->file('image'),
            $request->file('pdf_file')
        );

        return ApiResponse::success(
            new WorkoutPlanResource($workoutPlan),
            'Workout plan created successfully.',
            201
        );
    }

    #[Authorize('view', WorkoutPlan::class)]
    public function show(WorkoutPlan $workoutPlan): JsonResponse
    {
        return ApiResponse::success(
            new WorkoutPlanResource($workoutPlan),
            'Workout plan fetched successfully.');
    }

    #[Authorize('update', WorkoutPlan::class)]
    public function update(UpdateWorkoutPlanRequest $request, WorkoutPlan $workoutPlan): JsonResponse {

        $workoutPlan = $this->workoutPlanService->update(
            $workoutPlan,
            $request->validated(),
            $request->file('image'),
            $request->file('pdf_file')
        );

        return ApiResponse::success(
            new WorkoutPlanResource($workoutPlan),
            'Workout plan updated successfully.'
        );
    }

    #[Authorize('delete', WorkoutPlan::class)]
    public function destroy(WorkoutPlan $workoutPlan): JsonResponse
    {
        $this->workoutPlanService->destroy($workoutPlan);

        return ApiResponse::success(
            null,
            'Workout plan deleted successfully.'
        );
    }
}
