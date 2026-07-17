<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutDay\StoreWorkoutDayRequest;
use App\Http\Requests\WorkoutDay\UpdateWorkoutDayRequest;
use App\Http\Resources\WorkoutDayResource;
use App\Models\WorkoutDay;
use App\Services\WorkoutDayService;
use Illuminate\Http\JsonResponse;

class WorkoutDayController extends Controller
{
    public function __construct(
        protected WorkoutDayService $workoutDayService
    ) {}

    #[Permission(['can-view-workoutplan'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            WorkoutDayResource::collection(
                $this->workoutDayService->index()
            ),
            'Workout days fetched successfully.'
        );
    }

    #[Permission(['can-create-workoutplan'])]
    public function store(StoreWorkoutDayRequest $request): JsonResponse
    {
        $day = $this->workoutDayService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutDayResource($day),
            'Workout day created successfully.',
            201
        );
    }

    #[Permission(['can-view-workoutplan'])]
    public function show(WorkoutDay $workoutDay): JsonResponse
    {
        return ApiResponse::success(
            new WorkoutDayResource($workoutDay),
            'Workout day fetched successfully.'
        );
    }

    #[Permission(['can-update-workoutplan'])]
    public function update(
        UpdateWorkoutDayRequest $request,
        WorkoutDay $workoutDay
    ): JsonResponse {

        $day = $this->workoutDayService->update(
            $workoutDay,
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutDayResource($day),
            'Workout day updated successfully.'
        );
    }

    #[Permission(['can-deactivate-workoutplan'])]
    public function destroy(WorkoutDay $workoutDay): JsonResponse
    {
        $this->workoutDayService->destroy($workoutDay);

        return ApiResponse::success(
            null,
            'Workout day deleted successfully.'
        );
    }
}
