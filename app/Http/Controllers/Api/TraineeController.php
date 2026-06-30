<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trainee\StoreTraineeRequest;
use App\Http\Requests\Trainee\UpdateTraineeRequest;
use App\Http\Resources\TraineeResource;
use App\Models\Trainee;
use App\Services\TraineeService;
use Illuminate\Http\JsonResponse;

class TraineeController extends Controller
{
    public function __construct(
        protected TraineeService $traineeService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Trainee::class);

        $trainees = $this->traineeService->index();

        return ApiResponse::success(
            TraineeResource::collection($trainees),
            'Trainees fetched successfully.'
        );
    }

    public function store(StoreTraineeRequest $request): JsonResponse
    {
        $this->authorize('create', Trainee::class);

        $trainee = $this->traineeService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeResource($trainee),
            'Trainee created successfully.',
            201
        );
    }

    public function show(Trainee $trainee): JsonResponse
    {
        $this->authorize('view', $trainee);

        return ApiResponse::success(
            new TraineeResource(
                $trainee->load([
                    'user',
                    'business',
                ])
            ),
            'Trainee fetched successfully.'
        );
    }

    public function update(
        UpdateTraineeRequest $request,
        Trainee $trainee
    ): JsonResponse {

        $this->authorize('update', $trainee);

        $trainee = $this->traineeService->update(
            $trainee,
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeResource($trainee),
            'Trainee updated successfully.'
        );
    }

    public function destroy(Trainee $trainee): JsonResponse
    {
        $this->authorize('delete', $trainee);

        $this->traineeService->destroy($trainee);

        return ApiResponse::success(
            null,
            'Trainee deleted successfully.'
        );
    }
}
