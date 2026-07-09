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
use Illuminate\Routing\Attributes\Controllers\Authorize;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    #[Authorize('viewAny', Location::class)]
    public function index(): JsonResponse
    {
        $locations = $this->locationService->index();

        return ApiResponse::success(
            LocationResource::collection($locations),
            'Locations fetched successfully.'
        );
    }

    #[Authorize('create', Location::class)]
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $location = $this->locationService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new LocationResource($location),
            'Location created successfully.',
            201
        );
    }

    #[Authorize('view', Location::class)]
    public function show(Location $location): JsonResponse
    {
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

    #[Authorize('update', Location::class)]
    public function update(UpdateLocationRequest $request, Location $location): JsonResponse {

        $location = $this->locationService->update(
            $location,
            $request->validated()
        );

        return ApiResponse::success(
            new LocationResource($location),
            'Location updated successfully.'
        );
    }

    #[Authorize('delete', Location::class)]
    public function destroy(Location $location): JsonResponse
    {
        $this->locationService->destroy($location);

        return ApiResponse::success(
            null,
            'Location deleted successfully.'
        );
    }
}
