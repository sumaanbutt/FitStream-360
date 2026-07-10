<?php

namespace App\Services;

use App\Filters\CategoryFilter;
use App\Models\Category;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    use HasCode;

    public function index()
    {
        return (new CategoryFilter())
        ->apply(
            Category::withCount([
            'subCategory',
            'products',
            ])
        );
    }

    public function store(array $data): Category
    {
        try {
            return DB::transaction(function () use ($data) {
                $category = Category::create([
                    'organization_code' => $data['organization_code'],
                    'code' => $this->generateCode('CAT', Category::class),
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
//                    'status' => $data['status'] ?? true,
                ]);

                return $category->loadCount([
                    'subCategory',
                    'products',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Category Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Category $category, array $data): Category
    {
        try {
            return DB::transaction(function () use ($category, $data) {
                $category->update([
                    'name' => $data['name'] ?? $category->name,
                    'description' => $data['description'] ?? $category->description,
//                    'status' => $data['status'] ?? $category->status,
                ]);

                return $category->fresh()->loadCount([
                    'subCategory',
                    'products',
                ]);

            });

        } catch (\Throwable $e) {
            Log::error('Category Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(Category $category): bool
    {
        try {
            return DB::transaction(function () use ($category) {

                if ($category->subCategory()->exists()) {
                    throw new \Exception('Cannot delete category because it has sub categories.');
                }

                if ($category->products()->exists()) {
                    throw new \Exception('Cannot delete category because it has products.');
                }

                $category->delete();

                return true;

            });

        } catch (\Throwable $e) {
            Log::error('Category Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
