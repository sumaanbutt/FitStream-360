<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exercise\StoreExerciseRequest;
use App\Http\Requests\Exercise\UpdateExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use App\Services\ExerciseService;
use Illuminate\Http\JsonResponse;

class ExerciseController extends Controller
{
    public function __construct(
        protected ExerciseService $exerciseService
    ) {}

    #[Permission(['can-view-exercises'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            ExerciseResource::collection(
                $this->exerciseService->index()
            ),
            'Exercises fetched successfully.'
        );
    }

    #[Permission(['can-create-exercises'])]
    public function store(StoreExerciseRequest $request): JsonResponse
    {
        $exercise = $this->exerciseService->store(
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new ExerciseResource($exercise),
            'Exercise created successfully.',
            201
        );
    }

    #[Permission(['can-view-exercises'])]
    public function show(Exercise $exercise): JsonResponse
    {
        return ApiResponse::success(
            new ExerciseResource($exercise),
            'Exercise fetched successfully.'
        );
    }

    #[Permission(['can-update-exercises'])]
    public function update(UpdateExerciseRequest $request, Exercise $exercise): JsonResponse
    {
        $exercise = $this->exerciseService->update(
            $exercise,
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new ExerciseResource($exercise),
            'Exercise updated successfully.'
        );
    }

    #[Permission(['can-deactivate-exercises'])]
    public function destroy(Exercise $exercise): JsonResponse
    {
        $this->exerciseService->destroy($exercise);

        return ApiResponse::success(
            null,
            'Exercise deleted successfully.'
        );
    }
}
