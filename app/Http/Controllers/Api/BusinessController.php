<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Requests\Business\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Services\BusinessService;

class BusinessController extends Controller
{
    public function __construct(
        protected BusinessService $businessService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Business::class);

        $businesses = $this->businessService->index();

        return ApiResponse::success(
            BusinessResource::collection($businesses),
            'Businesses retrieved successfully.'
        );
    }

    public function store(StoreBusinessRequest $request)
    {
        $this->authorize('create', Business::class);

        $business = $this->businessService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new BusinessResource($business),
            'Business created successfully.'
        );
    }

    public function show(Business $business)
    {
        $this->authorize('view', $business);

        return ApiResponse::success(
            new BusinessResource($business)
        );
    }

    public function update(
        UpdateBusinessRequest $request,
        Business $business
    ) {
        $this->authorize('update', $business);

        $business = $this->businessService->update(
            $business,
            $request->validated()
        );

        return ApiResponse::success(
            new BusinessResource($business),
            'Business updated successfully.'
        );
    }

    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);

        $this->businessService->destroy($business);

        return ApiResponse::deleted(
            'Business deleted successfully.'
        );
    }
}
