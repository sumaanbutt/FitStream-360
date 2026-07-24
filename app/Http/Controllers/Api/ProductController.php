<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use JetBrains\PhpStorm\ArrayShape;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    #[Permission(['can-view-product'])]
    public function index(): JsonResponse
    {
        $products = $this->productService->index();

        return ApiResponse::success(
            ProductResource::collection($products),
            'Products fetched successfully.'
        );
    }

    #[Permission(['can-create-product'])]
    public function store(StoreProductRequest $request): JsonResponse
    {
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

    #[Permission(['can-view-product'])]
    public function show(Product $product): JsonResponse
    {
        return ApiResponse::success(
            new ProductResource(
                $product->load([
                    'business',
                    'category',
                    'subCategory',
                ])
            ),
            'Product fetched successfully.'
        );
    }

    #[Permission(['can-update-product'])]
    public function update(UpdateProductRequest $request, Product $product): JsonResponse {

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

    #[Permission(['can-deactivate-product'])]
    public function destroy(Product $product): JsonResponse
    {
        $this->productService->destroy($product);

        return ApiResponse::success(
            null,
            'Product deleted successfully.'
        );
    }
}
