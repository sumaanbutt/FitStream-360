<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Requests\Business\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Services\BusinessService;
use App\Attributes\Permission;

class BusinessController extends Controller
{
    public function __construct(protected BusinessService $businessService) {}

    #[Permission(['can-view-business'])]
    public function index()
    {
        $businesses = $this->businessService->index();

        return ApiResponse::success(
            BusinessResource::collection($businesses),
            'Businesses retrieved successfully.'
        );
    }

    #[Permission(['can-create-business'])]
    public function store(StoreBusinessRequest $request)
    {
        $business = $this->businessService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new BusinessResource($business),
            'Business created successfully.'
        );
    }

    #[Permission(['can-view-business'])]
    public function show(Business $business)
    {
        return ApiResponse::success(
            new BusinessResource($business)
        );
    }

    #[Permission(['can-update-business'])]
    public function update(UpdateBusinessRequest $request, Business $business) {

        $business = $this->businessService->update(
            $business,
            $request->validated()
        );

        return ApiResponse::success(
            new BusinessResource($business),
            'Business updated successfully.'
        );
    }

    #[Permission(['can-deactivate-business'])]
    public function destroy(Business $business)
    {
        $this->businessService->destroy($business);

        return ApiResponse::deleted(
            'Business deleted successfully.'
        );
    }
}
