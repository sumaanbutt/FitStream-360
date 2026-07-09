<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftSchedule\StoreShiftScheduleRequest;
use App\Http\Requests\ShiftSchedule\UpdateShiftScheduleRequest;
use App\Http\Resources\ShiftScheduleResource;
use App\Models\ShiftSchedule;
use App\Services\ShiftScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class ShiftScheduleController extends Controller
{
    public function __construct(
        protected ShiftScheduleService $shiftScheduleService
    ) {
    }

    #[Authorize('viewAny', ShiftSchedule::class)]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            ShiftScheduleResource::collection(
                $this->shiftScheduleService->index()
            ),
            'Shift schedules fetched successfully.'
        );
    }

    #[Authorize('create', ShiftSchedule::class)]
    public function store(StoreShiftScheduleRequest $request): JsonResponse
    {
        $shift = $this->shiftScheduleService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new ShiftScheduleResource($shift),
            'Shift schedule created successfully.',
            201
        );
    }

    #[Authorize('view', ShiftSchedule::class)]
    public function show(ShiftSchedule $shiftSchedule): JsonResponse
    {
        return ApiResponse::success(
            new ShiftScheduleResource(
                $shiftSchedule->load([
                    'organization',
                    'staff.user',
                ])
            ),
            'Shift schedule fetched successfully.'
        );
    }

    #[Authorize('update', ShiftSchedule::class)]
    public function update(UpdateShiftScheduleRequest $request, ShiftSchedule $shiftSchedule): JsonResponse {

        $shift = $this->shiftScheduleService->update(
            $shiftSchedule,
            $request->validated()
        );

        return ApiResponse::success(
            new ShiftScheduleResource($shift),
            'Shift schedule updated successfully.'
        );
    }

    #[Authorize('delete', ShiftSchedule::class)]
    public function destroy(ShiftSchedule $shiftSchedule): JsonResponse
    {
        $this->shiftScheduleService->destroy($shiftSchedule);

        return ApiResponse::success(
            null,
            'Shift schedule deleted successfully.'
        );
    }
}
