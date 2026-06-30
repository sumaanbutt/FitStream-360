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

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $staffService
    ) {}

    /**
     * Display a listing of staff.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Staff::class);

        $staff = $this->staffService->index();

        return ApiResponse::success(
            StaffResource::collection($staff),
            'Staff fetched successfully.'
        );
    }

    /**
     * Store a newly created staff.
     */
    public function store(StoreStaffRequest $request): JsonResponse
    {
        $this->authorize('create', Staff::class);

        $staff = $this->staffService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new StaffResource($staff),
            'Staff created successfully.',
            201
        );
    }

    /**
     * Display the specified staff.
     */
    public function show(Staff $staff): JsonResponse
    {
        $this->authorize('view', $staff);

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

    /**
     * Update the specified staff.
     */
    public function update(
        UpdateStaffRequest $request,
        Staff $staff
    ): JsonResponse {

        $this->authorize('update', $staff);

        $staff = $this->staffService->update(
            $staff,
            $request->validated()
        );

        return ApiResponse::success(
            new StaffResource($staff),
            'Staff updated successfully.'
        );
    }

    /**
     * Remove the specified staff.
     */
    public function destroy(Staff $staff): JsonResponse
    {
        $this->authorize('delete', $staff);

        $this->staffService->destroy($staff);

        return ApiResponse::success(
            null,
            'Staff deleted successfully.'
        );
    }
}
