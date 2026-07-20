<?php

namespace App\Services;

use App\Models\FoodCategory;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FoodCategoryService
{
    use HasCode;

    public function index()
    {
        return FoodCategory::with([
            'organization',
            'creator',
        ])
            ->withCount('foods');
    }

    public function store(array $data): FoodCategory
    {
        try {
            return DB::transaction(function () use ($data) {

                $foodCategory = FoodCategory::create([
                    'code' => $this->generateCode('FCT', FoodCategory::class),
                    'organization_code' => $data['organization_code'],
                    'created_by' => auth()->user()->code,
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'status' => $data['status'] ?? true,
                ]);

                return $foodCategory->load([
                    'organization',
                    'creator',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Food Category Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(FoodCategory $foodCategory, array $data): FoodCategory {
        try {
            return DB::transaction(function () use (
                $foodCategory,
                $data
            ) {
                $updateData = [
                    'name' => $data['name'] ?? $foodCategory->name,
                    'description' => $data['description'] ?? $foodCategory->description,
                    'status' => $data['status'] ?? $foodCategory->status,
                ];

                $foodCategory->update($updateData);

                return $foodCategory
                    ->fresh()
                    ->load([
                        'organization',
                        'creator',
                    ]);
            });

        } catch (\Throwable $e) {
            Log::error('Food Category Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(FoodCategory $foodCategory): bool {
        try {
            return DB::transaction(function () use ($foodCategory) {
                if ($foodCategory->foods()->exists()) {

                    throw new \Exception(
                        'This food category cannot be deleted because it contains foods.'
                    );
                }

                $foodCategory->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Food Category Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
