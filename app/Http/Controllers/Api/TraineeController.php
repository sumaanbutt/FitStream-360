<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trainee\StoreTraineeRequest;
use App\Http\Requests\Trainee\UpdateTraineeRequest;
use App\Http\Resources\TraineeResource;
use App\Models\Trainee;
use App\Services\TraineeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class TraineeController extends Controller
{
    public function __construct(
        protected TraineeService $traineeService
    ) {}

    #[Permission(['can-view-trainee'])]
    public function index(): JsonResponse
    {
        $trainees = $this->traineeService->index();

        return ApiResponse::success(
            TraineeResource::collection($trainees),
            'Trainees fetched successfully.'
        );
    }

    #[Permission(['can-create-trainee'])]
    public function store(StoreTraineeRequest $request): JsonResponse
    {
        $trainee = $this->traineeService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new TraineeResource($trainee),
            'Trainee created successfully.',
            201
        );
    }

    #[Permission(['can-view-trainee'])]
    public function show(Trainee $trainee): JsonResponse
    {
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

    #[Permission(['can-update-trainee'])]
    public function update(UpdateTraineeRequest $request, Trainee $trainee): JsonResponse {

        $trainee = $this->traineeService->update($trainee, $request->validated());

        return ApiResponse::success(
            new TraineeResource($trainee),
            'Trainee updated successfully.'
        );
    }

    #[Permission(['can-deactivate-trainee'])]
    public function destroy(Trainee $trainee): JsonResponse
    {
        $this->traineeService->destroy($trainee);

        return ApiResponse::success(
            null,
            'Trainee deleted successfully.'
        );
    }
}
