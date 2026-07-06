<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Location::class);

        $locations = $this->locationService->index();

        return ApiResponse::success(
            LocationResource::collection($locations),
            'Locations fetched successfully.'
        );
    }

    public function store(StoreLocationRequest $request): JsonResponse
    {
        $this->authorize('create', Location::class);

        $location = $this->locationService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new LocationResource($location),
            'Location created successfully.',
            201
        );
    }

    public function show(Location $location): JsonResponse
    {
        $this->authorize('view', $location);

        return ApiResponse::success(
            new LocationResource(
                $location->load([
                    'business',
                    'staff.user',
                ])
            ),
            'Location fetched successfully.'
        );
    }

    public function update(
        UpdateLocationRequest $request,
        Location $location
    ): JsonResponse {

        $this->authorize('update', $location);

        $location = $this->locationService->update(
            $location,
            $request->validated()
        );

        return ApiResponse::success(
            new LocationResource($location),
            'Location updated successfully.'
        );
    }

    public function destroy(Location $location): JsonResponse
    {
        $this->authorize('delete', $location);

        $this->locationService->destroy($location);

        return ApiResponse::success(
            null,
            'Location deleted successfully.'
        );
    }
}
