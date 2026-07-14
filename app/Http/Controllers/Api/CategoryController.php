<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    #[Permission(['can-view-category'])]
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->index();

        return ApiResponse::success(
            CategoryResource::collection($categories),
            'Categories fetched successfully.'
        );
    }

    #[Permission(['can-create-category'])]
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new CategoryResource($category),
            'Category created successfully.',
            201
        );
    }

    #[Permission(['can-view-category'])]
    public function show(Category $category): JsonResponse
    {
        return ApiResponse::success(
            new CategoryResource(
                $category->loadCount([
                    'subCategories',
                    'products',
                ])
            ),
            'Category fetched successfully.'
        );
    }

    #[Permission(['can-update-category'])]
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse {

        $category = $this->categoryService->update(
            $category,
            $request->validated()
        );

        return ApiResponse::success(
            new CategoryResource($category),
            'Category updated successfully.'
        );
    }

    #[Permission(['can-deactivate-category'])]
    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->destroy($category);

        return ApiResponse::success(
            null,
            'Category deleted successfully.'
        );
    }
}
