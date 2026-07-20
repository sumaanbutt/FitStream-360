<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutDayExercise\StoreWorkoutDayExerciseRequest;
use App\Http\Requests\WorkoutDayExercise\UpdateWorkoutDayExerciseRequest;
use App\Http\Resources\WorkoutDayExerciseResource;
use App\Models\WorkoutDayExercise;
use App\Services\WorkoutDayExerciseService;
use Illuminate\Http\JsonResponse;

class WorkoutDayExerciseController extends Controller
{
    public function __construct(
        protected WorkoutDayExerciseService $workoutDayExerciseService
    ) {}

    #[Permission(['can-view-workout-day-exercises'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            WorkoutDayExerciseResource::collection(
                $this->workoutDayExerciseService->index()
            ),
            'Workout day exercises fetched successfully.'
        );
    }

    #[Permission(['can-create-workout-day-exercises'])]
    public function store(StoreWorkoutDayExerciseRequest $request): JsonResponse
    {
        $exercise = $this->workoutDayExerciseService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutDayExerciseResource($exercise),
            'Workout day exercise created successfully.',
            201
        );
    }

    #[Permission(['can-view-workout-day-exercises'])]
    public function show(WorkoutDayExercise $workoutDayExercise): JsonResponse
    {
        return ApiResponse::success(
            new WorkoutDayExerciseResource($workoutDayExercise),
            'Workout day exercise fetched successfully.'
        );
    }

    #[Permission(['can-update-workout-day-exercises'])]
    public function update(UpdateWorkoutDayExerciseRequest $request, WorkoutDayExercise $workoutDayExercise): JsonResponse
    {
        $exercise = $this->workoutDayExerciseService->update(
            $workoutDayExercise,
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutDayExerciseResource($exercise),
            'Workout day exercise updated successfully.'
        );
    }

    #[Permission(['can-deactivate-workout-day-exercises'])]
    public function destroy(WorkoutDayExercise $workoutDayExercise): JsonResponse
    {
        $this->workoutDayExerciseService->destroy(
            $workoutDayExercise
        );

        return ApiResponse::success(
            null,
            'Workout day exercise deleted successfully.'
        );
    }
}
