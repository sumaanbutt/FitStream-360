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

class ShiftScheduleController extends Controller
{
    public function __construct(
        protected ShiftScheduleService $shiftScheduleService
    ) {
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', ShiftSchedule::class);

        return ApiResponse::success(
            ShiftScheduleResource::collection(
                $this->shiftScheduleService->index()
            ),
            'Shift schedules fetched successfully.'
        );
    }

    public function store(StoreShiftScheduleRequest $request): JsonResponse
    {
        $this->authorize('create', ShiftSchedule::class);

        $shift = $this->shiftScheduleService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new ShiftScheduleResource($shift),
            'Shift schedule created successfully.',
            201
        );
    }

    public function show(ShiftSchedule $shiftSchedule): JsonResponse
    {
        $this->authorize('view', $shiftSchedule);

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

    public function update(UpdateShiftScheduleRequest $request, ShiftSchedule $shiftSchedule): JsonResponse {

        $this->authorize('update', $shiftSchedule);

        $shift = $this->shiftScheduleService->update(
            $shiftSchedule,
            $request->validated()
        );

        return ApiResponse::success(
            new ShiftScheduleResource($shift),
            'Shift schedule updated successfully.'
        );
    }

    public function destroy(ShiftSchedule $shiftSchedule): JsonResponse
    {
        $this->authorize('delete', $shiftSchedule);

        $this->shiftScheduleService->destroy($shiftSchedule);

        return ApiResponse::success(
            null,
            'Shift schedule deleted successfully.'
        );
    }
}
