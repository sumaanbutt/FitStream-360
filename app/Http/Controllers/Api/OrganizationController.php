<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organizationService
    ) {}

//    #[Authorize('viewAny', Organization::class)]
    #[Permission(['can-view-organization'])]
    public function index()
    {
//        $this->authorize('viewAny', Organization::class);

        $organizations = $this->organizationService->index();

        return ApiResponse::success(
            OrganizationResource::collection($organizations),
            'Organizations retrieved successfully.'
        );
    }

//    #[Authorize('create', Organization::class)]
    public function store(StoreOrganizationRequest $request)
    {
        $organization = $this->organizationService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new OrganizationResource($organization),
            'Organization created successfully.'
        );
    }

//    #[Authorize('view', Organization::class)]
    public function show(Organization $organization)
    {
        return ApiResponse::success(
            new OrganizationResource($organization)
        );
    }

//    #[Authorize('update', Organization::class)]
    public function update(UpdateOrganizationRequest $request, Organization $organization){

        $organization = $this->organizationService->update(
            $organization,
            $request->validated()
        );

        return ApiResponse::success(
            new OrganizationResource($organization),
            'Organization updated successfully.'
        );
    }

//    #[Authorize('delete', Organization::class)]
    public function destroy(Organization $organization)
    {
        $this->organizationService->destroy($organization);

        return ApiResponse::success(
            message: 'Organization deleted successfully.'
        );
    }
}
