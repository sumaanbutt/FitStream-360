<?php

namespace App\Services;

use App\Filters\ProductFilter;
use App\Models\Product;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    use HasCode;
    public function __construct()
    {}

    public function index()
    {
        return (new ProductFilter())
            ->apply(
            Product::with([
            'category',
            'subCategory',
            ])
        );
    }

    public function store(array $data, ?UploadedFile $image): Product {

        try {
            return DB::transaction(function () use ($data, $image) {

                $imagePath = null;
                if ($image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs(
                        'products',
                        $imageName,
                        'public'
                    );
                }

                $code = $this->generateCode('PRD', Product::class);

                $product = Product::create([
                    'code' => $code,
                    'sku' => 'SKU-' . $code,
                    'category_code' => $data['category_code'],
                    'subcategory_code' => $data['subcategory_code'],
                    'product_name' => $data['name'],
                    'product_description' => $data['description'] ?? null,
                    'product_price' => $data['product_price'],
                    'quantity' => $data['quantity'],
                    'product_image' => $imagePath,
                    'status' => $data['status'] ?? true,
                ]);

                return $product->load([
                    'category',
                    'subCategory',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Product Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Product $product, array $data, ?UploadedFile $image): Product
    {
        try {
            return DB::transaction(function () use ($product, $data, $image) {

                $updateData = [
                    'category_code' => $data['category_code'] ?? $product->category_code,
                    'sub_category_code' => $data['sub_category_code'] ?? $product->sub_category_code,
                    'product_name' => $data['name'] ?? $product->name,
                    'product_description' => $data['description'] ?? $product->description,
                    'sku' => $data['sku'] ?? $product->sku,
                    'product_price' => $data['product_price'] ?? $product->cost_price,
                    'quantity' => $data['quantity'] ?? $product->quantity,
                    'status' => $data['status'] ?? $product->status,
                ];

                if ($image) {
                    if (
                        $product->image &&
                        Storage::disk('public')->exists($product->image)
                    ) {
                        Storage::disk('public')->delete($product->image);
                    }

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $updateData['image'] = $image->storeAs(
                        'products',
                        $imageName,
                        'public'
                    );
                }

                $product->update($updateData);

                return $product->fresh()->load([
                    'category',
                    'subCategory',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Product Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function destroy(Product $product): bool
    {
        try {
            return DB::transaction(function () use ($product) {
                if ($product->orderItems()->exists()) {
                    throw new \Exception('Cannot delete product because it has order history.');
                }

                if (
                    $product->image &&
                    Storage::disk('public')->exists($product->image)
                ) {
                    Storage::disk('public')->delete($product->image);
                }

                $product->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Product Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
