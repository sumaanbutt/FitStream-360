<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutWeek\StoreWorkoutWeekRequest;
use App\Http\Requests\WorkoutWeek\UpdateWorkoutWeekRequest;
use App\Http\Resources\WorkoutWeekResource;
use App\Models\WorkoutWeek;
use App\Services\WorkoutWeekService;
use Illuminate\Http\JsonResponse;

class WorkoutWeekController extends Controller
{
    public function __construct(
        protected WorkoutWeekService $workoutWeekService
    ) {}

    #[Permission(['can-view-workoutplan'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            WorkoutWeekResource::collection(
                $this->workoutWeekService->index()
            ),
            'Workout weeks fetched successfully.'
        );
    }

    #[Permission(['can-create-workoutplan'])]
    public function store(StoreWorkoutWeekRequest $request): JsonResponse
    {
        $week = $this->workoutWeekService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutWeekResource($week),
            'Workout week created successfully.',
            201
        );
    }

    #[Permission(['can-view-workoutplan'])]
    public function show(WorkoutWeek $workoutWeek): JsonResponse
    {
        return ApiResponse::success(
            new WorkoutWeekResource($workoutWeek),
            'Workout week fetched successfully.'
        );
    }

    #[Permission(['can-update-workoutplan'])]
    public function update(
        UpdateWorkoutWeekRequest $request,
        WorkoutWeek $workoutWeek
    ): JsonResponse {

        $week = $this->workoutWeekService->update(
            $workoutWeek,
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutWeekResource($week),
            'Workout week updated successfully.'
        );
    }

    #[Permission(['can-deactivate-workoutplan'])]
    public function destroy(WorkoutWeek $workoutWeek): JsonResponse
    {
        $this->workoutWeekService->destroy($workoutWeek);

        return ApiResponse::success(
            null,
            'Workout week deleted successfully.'
        );
    }
}
