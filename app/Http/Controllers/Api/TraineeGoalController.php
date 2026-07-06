<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeGoal\StoreTraineeGoalRequest;
use App\Http\Requests\TraineeGoal\UpdateTraineeGoalRequest;
use App\Http\Resources\TraineeGoalResource;
use App\Models\TraineeGoals;
use App\Services\TraineeGoalService;
use Illuminate\Http\JsonResponse;

class TraineeGoalController extends Controller
{
    public function __construct(
        protected TraineeGoalService $traineeGoalService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', TraineeGoals::class);

        $goals = $this->traineeGoalService->index();

        return ApiResponse::success(
            TraineeGoalResource::collection($goals),
            'Trainee goals fetched successfully.'
        );
    }

    public function store(StoreTraineeGoalRequest $request): JsonResponse
    {
        $this->authorize('create', TraineeGoals::class);

        $goal = $this->traineeGoalService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalResource($goal),
            'Trainee goal created successfully.',
            201
        );
    }

    public function show(TraineeGoals $traineeGoal): JsonResponse
    {
        $this->authorize('view', $traineeGoal);

        return ApiResponse::success(
            new TraineeGoalResource(
                $traineeGoal->load([
                    'trainee.user',
                    'attachments.uploader',
                ])
            ),
            'Trainee goal fetched successfully.'
        );
    }

    public function update(UpdateTraineeGoalRequest $request, TraineeGoals $traineeGoal): JsonResponse {

        $this->authorize('update', $traineeGoal);

        $goal = $this->traineeGoalService->update(
            $traineeGoal,
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalResource($goal),
            'Trainee goal updated successfully.'
        );
    }

    public function destroy(TraineeGoals $traineeGoal): JsonResponse
    {
        $this->authorize('delete', $traineeGoal);

        $this->traineeGoalService->destroy($traineeGoal);

        return ApiResponse::success(
            null,
            'Trainee goal deleted successfully.'
        );
    }
}
