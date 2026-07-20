<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;

class EquipmentController extends Controller
{
    public function __construct(
        protected EquipmentService $equipmentService
    ) {}

    #[Permission(['can-view-equipments'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            EquipmentResource::collection(
                $this->equipmentService->index()
            ),
            'Equipments fetched successfully.'
        );
    }

    #[Permission(['can-create-equipments'])]
    public function store(StoreEquipmentRequest $request): JsonResponse
    {
        $equipment = $this->equipmentService->store(
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new EquipmentResource($equipment),
            'Equipment created successfully.',
            201
        );
    }

    #[Permission(['can-view-equipments'])]
    public function show(Equipment $equipment): JsonResponse
    {
        return ApiResponse::success(
            new EquipmentResource($equipment),
            'Equipment fetched successfully.'
        );
    }

    #[Permission(['can-update-equipments'])]
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        $equipment = $this->equipmentService->update(
            $equipment,
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new EquipmentResource($equipment),
            'Equipment updated successfully.'
        );
    }

    #[Permission(['can-deactivate-equipments'])]
    public function destroy(Equipment $equipment): JsonResponse
    {
        $this->equipmentService->destroy($equipment);

        return ApiResponse::success(
            null,
            'Equipment deleted successfully.'
        );
    }
}
