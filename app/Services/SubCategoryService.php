<?php

namespace App\Services;

use App\Filters\SubCategoryFilter;
use App\Models\SubCategory;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class SubCategoryService
{
    use HasCode;
    public function __construct()
    {}

    public function index()
    {
        return (new SubCategoryFilter())
        ->apply(
            SubCategory::with([
                'category',
            ])
                ->withCount([
                    'products',
                ])
            );
    }

    public function store(array $data): SubCategory
    {
        try {
            return DB::transaction(function () use ($data) {
                $subCategory = SubCategory::create([
                    'code' => $this->generateCode('SCT', SubCategory::class),
                    'category_code' => $data['category_code'],
                    'name' => $data['name'],
                    'status' => $data['status'] ?? true,
                ]);

                return $subCategory
                    ->load('category')
                    ->loadCount('products');
            });

        } catch (\Throwable $e) {
            Log::error('Sub Category Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(SubCategory $subCategory, array $data): SubCategory
    {
        try {
            return DB::transaction(function () use ($subCategory, $data) {
                $subCategory->update([
                    'category_code' => $data['category_code'] ?? $subCategory->category_code,
                    'name' => $data['name'] ?? $subCategory->name,
                    'status' => $data['status'] ?? $subCategory->status,
                ]);

                return $subCategory->fresh()
                    ->load('category')
                    ->loadCount('products');
            });

        } catch (\Throwable $e) {
            Log::error('Sub Category Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(SubCategory $subCategory): bool
    {
        try {
            return DB::transaction(function () use ($subCategory) {
                if ($subCategory->products()->exists()) {
                    throw new \Exception(
                        'Cannot delete sub category because it has products.'
                    );
                }

                $subCategory->delete();
                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Sub Category Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
