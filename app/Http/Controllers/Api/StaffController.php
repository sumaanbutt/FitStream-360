<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $staffService
    ) {}

    #[Authorize('viewAny', Staff::class)]
    public function index(): JsonResponse
    {
        $staff = $this->staffService->index();

        return ApiResponse::success(
            StaffResource::collection($staff),
            'Staff fetched successfully.'
        );
    }

    #[Authorize('create', Staff::class)]
    public function store(StoreStaffRequest $request): JsonResponse
    {
        $staff = $this->staffService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new StaffResource($staff),
            'Staff created successfully.',
            201
        );
    }

    #[Authorize('view', Staff::class)]
    public function show(Staff $staff): JsonResponse
    {
        return ApiResponse::success(
            new StaffResource(
                $staff->load([
                    'user',
                    'business',
                    'trainer',
                ])
            ),
            'Staff fetched successfully.'
        );
    }

    #[Authorize('update', Staff::class)]
    public function update(UpdateStaffRequest $request, Staff $staff): JsonResponse {

        $staff = $this->staffService->update(
            $staff,
            $request->validated()
        );

        return ApiResponse::success(
            new StaffResource($staff),
            'Staff updated successfully.'
        );
    }

    #[Authorize('delete', Staff::class)]
    public function destroy(Staff $staff): JsonResponse
    {
        $this->staffService->destroy($staff);

        return ApiResponse::success(
            null,
            'Staff deleted successfully.'
        );
    }
}
