<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\SubCategory\UpdateSubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\SubCategory;
use App\Services\SubCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class SubCategoryController extends Controller
{
    public function __construct(
        protected SubCategoryService $subCategoryService
    ) {}

    #[Permission(['can-view-subcategory'])]
    public function index(): JsonResponse
    {
        $subCategories = $this->subCategoryService->index();

        return ApiResponse::success(
            SubCategoryResource::collection($subCategories),
            'Sub categories fetched successfully.'
        );
    }

    #[Permission(['can-create-subcategory'])]
    public function store(StoreSubCategoryRequest $request): JsonResponse
    {
        $subCategory = $this->subCategoryService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new SubCategoryResource($subCategory),
            'Sub category created successfully.',
            201
        );
    }

    #[Permission(['can-view-subcategory'])]
    public function show(SubCategory $subCategory): JsonResponse
    {
        return ApiResponse::success(
            new SubCategoryResource(
                $subCategory->load('category')
                    ->loadCount('products')
            ),
            'Sub category fetched successfully.'
        );
    }

    #[Permission(['can-update-subcategory'])]
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory): JsonResponse {

        $subCategory = $this->subCategoryService->update($subCategory, $request->validated());

        return ApiResponse::success(
            new SubCategoryResource($subCategory),
            'Sub category updated successfully.'
        );
    }

    #[Permission(['can-deactivate-subcategory'])]
    public function destroy(SubCategory $subCategory): JsonResponse
    {
        $this->subCategoryService->destroy($subCategory);

        return ApiResponse::success(
            null,
            'Sub category deleted successfully.'
        );
    }
}
