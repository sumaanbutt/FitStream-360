<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\SubCategory\UpdateSubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\SubCategory;
use App\Services\SubCategoryService;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends Controller
{
    public function __construct(
        protected SubCategoryService $subCategoryService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', SubCategory::class);

        $subCategories = $this->subCategoryService->index();

        return ApiResponse::success(
            SubCategoryResource::collection($subCategories),
            'Sub categories fetched successfully.'
        );
    }

    public function store(StoreSubCategoryRequest $request): JsonResponse
    {
        $this->authorize('create', SubCategory::class);

        $subCategory = $this->subCategoryService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new SubCategoryResource($subCategory),
            'Sub category created successfully.',
            201
        );
    }

    public function show(SubCategory $subCategory): JsonResponse
    {
        $this->authorize('view', $subCategory);

        return ApiResponse::success(
            new SubCategoryResource(
                $subCategory->load('category')
                    ->loadCount('products')
            ),
            'Sub category fetched successfully.'
        );
    }

    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory): JsonResponse {

        $this->authorize('update', $subCategory);

        $subCategory = $this->subCategoryService->update($subCategory, $request->validated());

        return ApiResponse::success(
            new SubCategoryResource($subCategory),
            'Sub category updated successfully.'
        );
    }

    /**
     * Delete sub category.
     */
    public function destroy(SubCategory $subCategory): JsonResponse
    {
        $this->authorize('delete', $subCategory);

        $this->subCategoryService->destroy($subCategory);

        return ApiResponse::success(
            null,
            'Sub category deleted successfully.'
        );
    }
}
