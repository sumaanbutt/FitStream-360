<?php

namespace App\Http\Controllers\Api;

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


    public function index()
    {
        $this->authorize('viewAny', Organization::class);

        $organizations = $this->organizationService->index();

        return ApiResponse::success(
            OrganizationResource::collection($organizations),
            'Organizations retrieved successfully.'
        );
    }


    public function store(StoreOrganizationRequest $request)
    {
        $this->authorize('create', Organization::class);

        $organization = $this->organizationService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new OrganizationResource($organization),
            'Organization created successfully.'
        );
    }


    public function show(Organization $organization)
    {
        $this->authorize('view', $organization);

        return ApiResponse::success(
            new OrganizationResource($organization)
        );
    }


    public function update(UpdateOrganizationRequest $request, Organization $organization){
        $this->authorize('update', $organization);

        $organization = $this->organizationService->update(
            $organization,
            $request->validated()
        );

        return ApiResponse::success(
            new OrganizationResource($organization),
            'Organization updated successfully.'
        );
    }


    public function destroy(Organization $organization)
    {
        $this->authorize('delete', $organization);

        $this->organizationService->destroy($organization);

        return ApiResponse::success(
            message: 'Organization deleted successfully.'
        );
    }
}
