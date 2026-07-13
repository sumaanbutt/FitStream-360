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

    #[Permission(['can-view-organization'])]
    public function index()
    {
        $organizations = $this->organizationService->index();

        return ApiResponse::success(
            OrganizationResource::collection($organizations),
            'Organizations retrieved successfully.'
        );
    }

    #[Permission(['can-create-organization'])]
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

    #[Permission(['can-view-organization'])]
    public function show(Organization $organization)
    {
        return ApiResponse::success(
            new OrganizationResource($organization)
        );
    }

    #[Permission(['can-update-organization'])]
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

    #[Permission(['can-deactivate-organization'])]
    public function destroy(Organization $organization)
    {
        $this->organizationService->destroy($organization);

        return ApiResponse::success(
            message: 'Organization deleted successfully.'
        );
    }
}
