<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeGoalProgress\StoreTraineeGoalProgressRequest;
use App\Http\Requests\TraineeGoalProgress\UpdateTraineeGoalProgressRequest;
use App\Http\Resources\TraineeGoalProgressResource;
use App\Models\TraineeGoalProgress;
use App\Services\TraineeGoalProgressService;
use Illuminate\Http\JsonResponse;

class TraineeGoalProgressController extends Controller
{
    public function __construct(
        protected TraineeGoalProgressService $service
    ) {
    }

    #[Permission(['can-view-trainee-goal-progress'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            TraineeGoalProgressResource::collection(
                $this->service->index()
            ),
            'Progress records fetched successfully.'
        );
    }

    #[Permission(['can-create-trainee-goal-progress'])]
    public function store(StoreTraineeGoalProgressRequest $request): JsonResponse
    {
        $progress = $this->service->store(
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalProgressResource($progress),
            'Progress recorded successfully.',
            201
        );
    }

    #[Permission(['can-view-trainee-goal-progress'])]
    public function show(TraineeGoalProgress $traineeGoalProgress): JsonResponse
    {
        return ApiResponse::success(
            new TraineeGoalProgressResource(
                $traineeGoalProgress->load([
                    'traineeGoal',
                ])
            ),
            'Progress fetched successfully.'
        );
    }

    #[Permission(['can-update-trainee-goal-progress'])]
    public function update(UpdateTraineeGoalProgressRequest $request, TraineeGoalProgress $traineeGoalProgress): JsonResponse {

        $progress = $this->service->update(
            $traineeGoalProgress,
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalProgressResource($progress),
            'Progress updated successfully.'
        );
    }

    #[Permission(['can-deactivate-trainee-goal-progress'])]
    public function destroy(TraineeGoalProgress $traineeGoalProgress): JsonResponse {

        $this->service->destroy($traineeGoalProgress);

        return ApiResponse::success(
            null,
            'Progress deleted successfully.'
        );
    }
}
