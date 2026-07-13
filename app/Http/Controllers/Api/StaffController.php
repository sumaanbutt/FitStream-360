<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
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

    #[Permission(['can-view-staff'])]
    public function index(): JsonResponse
    {
        $staff = $this->staffService->index();

        return ApiResponse::success(
            StaffResource::collection($staff),
            'Staff fetched successfully.'
        );
    }

    #[Permission(['can-create-staff'])]
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

    #[Permission(['can-view-staff'])]
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

    #[Permission(['can-update-staff'])]
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

    #[Permission(['can-deactivate-staff'])]
    public function destroy(Staff $staff): JsonResponse
    {
        $this->staffService->destroy($staff);

        return ApiResponse::success(
            null,
            'Staff deleted successfully.'
        );
    }
}
