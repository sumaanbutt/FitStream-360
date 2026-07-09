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
use Illuminate\Routing\Attributes\Controllers\Authorize;

class TraineeGoalController extends Controller
{
    public function __construct(
        protected TraineeGoalService $traineeGoalService
    ) {}

    #[Authorize('viewAny', TraineeGoals::class)]
    public function index(): JsonResponse
    {
        $goals = $this->traineeGoalService->index();

        return ApiResponse::success(
            TraineeGoalResource::collection($goals),
            'Trainee goals fetched successfully.'
        );
    }

    #[Authorize('create', TraineeGoals::class)]
    public function store(StoreTraineeGoalRequest $request): JsonResponse
    {
        $goal = $this->traineeGoalService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalResource($goal),
            'Trainee goal created successfully.',
            201
        );
    }

    #[Authorize('view', TraineeGoals::class)]
    public function show(TraineeGoals $traineeGoal): JsonResponse
    {
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

    #[Authorize('update', TraineeGoals::class)]
    public function update(UpdateTraineeGoalRequest $request, TraineeGoals $traineeGoal): JsonResponse {

        $goal = $this->traineeGoalService->update(
            $traineeGoal,
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalResource($goal),
            'Trainee goal updated successfully.'
        );
    }

    #[Authorize('delete', TraineeGoals::class)]
    public function destroy(TraineeGoals $traineeGoal): JsonResponse
    {
        return ApiResponse::success(
            null,
            'Trainee goal deleted successfully.'
        );
    }
}
