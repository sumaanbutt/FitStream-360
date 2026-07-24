<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeGoal\StoreTraineeGoalRequest;
use App\Http\Requests\TraineeGoal\UpdateTraineeGoalRequest;
use App\Http\Resources\TraineeGoalResource;
use App\Models\TraineeGoal;
use App\Services\TraineeGoalService;
use App\Models\TraineeGoals;
use Illuminate\Http\JsonResponse;

class TraineeGoalController extends Controller
{
    public function __construct(
        protected TraineeGoalService $service
    ) {}

    #Permission
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            TraineeGoalResource::collection(
                $this->service->index()
            ),
            'Trainee goals fetched successfully.'
        );
    }

    public function store(StoreTraineeGoalRequest $request): JsonResponse
    {
        $goal = $this->service->store(
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalResource($goal),
            'Trainee goal created successfully.',
            201
        );
    }

    public function show(TraineeGoalS $traineeGoal): JsonResponse
    {
        return ApiResponse::success(
            new TraineeGoalResource(
                $traineeGoal->load([
                    'business',
                    'trainee',
                    'creator',
                ])
            ),
            'Trainee goal fetched successfully.'
        );
    }

    public function update(UpdateTraineeGoalRequest $request, TraineeGoalS $traineeGoal): JsonResponse
    {
        $goal = $this->service->update(
            $traineeGoal,
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeGoalResource($goal),
            'Trainee goal updated successfully.'
        );
    }

    public function destroy(TraineeGoalS $traineeGoal): JsonResponse
    {
        $this->service->destroy($traineeGoal);

        return ApiResponse::success(
            null,
            'Trainee goal deleted successfully.'
        );
    }
}
