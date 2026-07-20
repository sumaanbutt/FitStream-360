<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutPlanEquipment\StoreWorkoutPlanEquipmentRequest;
use App\Http\Requests\WorkoutPlanEquipment\UpdateWorkoutPlanEquipmentRequest;
use App\Http\Resources\WorkoutPlanEquipmentResource;
use App\Models\WorkoutPlanEquipment;
use App\Services\WorkoutPlanEquipmentService;
use Illuminate\Http\JsonResponse;

class WorkoutPlanEquipmentController extends Controller
{
    public function __construct(
        protected WorkoutPlanEquipmentService $workoutPlanEquipmentService
    ) {}

    #[Permission(['can-view-workoutplan-equipments'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            WorkoutPlanEquipmentResource::collection(
                $this->workoutPlanEquipmentService->index()
            ),
            'Workout plan equipments fetched successfully.'
        );
    }

    #[Permission(['can-create-workoutplan-equipments'])]
    public function store(StoreWorkoutPlanEquipmentRequest $request): JsonResponse
    {
        $equipment = $this->workoutPlanEquipmentService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutPlanEquipmentResource($equipment),
            'Workout plan equipment created successfully.',
            201
        );
    }

    #[Permission(['can-view-workoutplan-equipments'])]
    public function show(WorkoutPlanEquipment $workoutPlanEquipment): JsonResponse
    {
        return ApiResponse::success(
            new WorkoutPlanEquipmentResource($workoutPlanEquipment),
            'Workout plan equipment fetched successfully.'
        );
    }

    #[Permission(['can-update-workoutplan-equipments'])]
    public function update(UpdateWorkoutPlanEquipmentRequest $request, WorkoutPlanEquipment $workoutPlanEquipment): JsonResponse
    {
        $equipment = $this->workoutPlanEquipmentService->update(
            $workoutPlanEquipment,
            $request->validated()
        );

        return ApiResponse::success(
            new WorkoutPlanEquipmentResource($equipment),
            'Workout plan equipment updated successfully.'
        );
    }

    #[Permission(['can-deactivate-workoutplan-equipments'])]
    public function destroy(WorkoutPlanEquipment $workoutPlanEquipment): JsonResponse
    {
        $this->workoutPlanEquipmentService->destroy(
            $workoutPlanEquipment
        );

        return ApiResponse::success(
            null,
            'Workout plan equipment deleted successfully.'
        );
    }
}
