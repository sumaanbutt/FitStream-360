<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display all categories.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Category::class);

        $categories = $this->categoryService->index();

        return ApiResponse::success(
            CategoryResource::collection($categories),
            'Categories fetched successfully.'
        );
    }

    /**
     * Store category.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $this->authorize('create', Category::class);

        $category = $this->categoryService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new CategoryResource($category),
            'Category created successfully.',
            201
        );
    }

    /**
     * Display category.
     */
    public function show(Category $category): JsonResponse
    {
        $this->authorize('view', $category);

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

    /**
     * Update category.
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): JsonResponse {

        $this->authorize('update', $category);

        $category = $this->categoryService->update(
            $category,
            $request->validated()
        );

        return ApiResponse::success(
            new CategoryResource($category),
            'Category updated successfully.'
        );
    }

    /**
     * Delete category.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        $this->categoryService->destroy($category);

        return ApiResponse::success(
            null,
            'Category deleted successfully.'
        );
    }
}
