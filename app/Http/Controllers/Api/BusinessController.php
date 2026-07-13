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
use Illuminate\Routing\Attributes\Controllers\Authorize;

class BusinessController extends Controller
{
    public function __construct(protected BusinessService $businessService) {}

//    #[Authorize('permission', 'business.index')]
    #[Permission(['can-view-business'])]
    public function index()
    {
        $businesses = $this->businessService->index();

        return ApiResponse::success(
            BusinessResource::collection($businesses),
            'Businesses retrieved successfully.'
        );
    }

//    #[Authorize('create', Business::class)]
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

//    #[Authorize('view', Business::class)]
    public function show(Business $business)
    {
        return ApiResponse::success(
            new BusinessResource($business)
        );
    }

//    #[Authorize('update', Business::class)]
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

//    #[Authorize('delete', Business::class)]
    public function destroy(Business $business)
    {
        $this->businessService->destroy($business);

        return ApiResponse::deleted(
            'Business deleted successfully.'
        );
    }
}
