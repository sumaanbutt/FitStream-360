<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Display a listing of products.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Product::class);

        $products = $this->productService->index();

        return ApiResponse::success(
            ProductResource::collection($products),
            'Products fetched successfully.'
        );
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $product = $this->productService->store(
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new ProductResource($product),
            'Product created successfully.',
            201
        );
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): JsonResponse
    {
        $this->authorize('view', $product);

        return ApiResponse::success(
            new ProductResource(
                $product->load([
                    'category',
                    'subCategory',
                ])
            ),
            'Product fetched successfully.'
        );
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse {

        $this->authorize('update', $product);

        $product = $this->productService->update(
            $product,
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success(
            new ProductResource($product),
            'Product updated successfully.'
        );
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', $product);

        $this->productService->destroy($product);

        return ApiResponse::success(
            null,
            'Product deleted successfully.'
        );
    }
}
