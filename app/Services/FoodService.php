<?php

namespace App\Services;

use App\Models\Food;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FoodService
{
    use HasCode;

    public function index()
    {
        return Food::with([
            'organization',
            'creator',
            'foodCategory',
        ])
            ->paginate(10);
    }

    public function store(array $data, ?UploadedFile $image): Food
    {
        try {
            return DB::transaction(function () use ($data, $image) {

                $imagePath = null;

                if ($image) {

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'foods',
                        $imageName,
                        'public'
                    );
                }

                $food = Food::create([
                    'code' => $this->generateCode('FOD', Food::class),
                    'organization_code' => $data['organization_code'],
                    'created_by' => auth()->user()->code,
                    'food_category_code' => $data['food_category_code'] ?? null,
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'brand' => $data['brand'] ?? null,
                    'serving_unit' => $data['serving_unit'],
                    'serving_size' => $data['serving_size'],
                    'calories' => $data['calories'],
                    'protein' => $data['protein'] ?? 0,
                    'carbohydrates' => $data['carbohydrates'] ?? 0,
                    'fat' => $data['fat'] ?? 0,
                    'fiber' => $data['fiber'] ?? 0,
                    'image_path' => $imagePath,
                    'status' => $data['status'] ?? true,
                ]);

                return $food->load([
                    'organization',
                    'creator',
                    'foodCategory',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Food Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Food $food, array $data, ?UploadedFile $image): Food
    {
        try {
            return DB::transaction(function () use (
                $food,
                $data,
                $image
            ) {
                $updateData = [
                    'name' => $data['name'] ?? $food->name,
                    'description' => $data['description'] ?? $food->description,
                    'brand' => $data['brand'] ?? $food->brand,
                    'serving_unit' => $data['serving_unit'] ?? $food->serving_unit,
                    'serving_size' => $data['serving_size'] ?? $food->serving_size,
                    'calories' => $data['calories'] ?? $food->calories,
                    'protein' => $data['protein'] ?? $food->protein,
                    'carbohydrates' => $data['carbohydrates'] ?? $food->carbohydrates,
                    'fat' => $data['fat'] ?? $food->fat,
                    'fiber' => $data['fiber'] ?? $food->fiber,
                    'status' => $data['status'] ?? $food->status,
                ];

                if ($image) {

                    if (
                        $food->image_path &&
                        Storage::disk('public')->exists($food->image_path)
                    ) {
                        Storage::disk('public')->delete($food->image_path);
                    }

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $updateData['image_path'] = $image->storeAs(
                        'foods',
                        $imageName,
                        'public'
                    );
                }

                $food->update($updateData);

                return $food
                    ->fresh()
                    ->load([
                        'organization',
                        'creator',
                        'foodCategory',
                    ]);

            });

        } catch (\Throwable $e) {
            Log::error('Food Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(Food $food): bool
    {
        try {
            return DB::transaction(function () use ($food) {

                if (
                    $food->image_path &&
                    Storage::disk('public')->exists($food->image_path)
                ) {
                    Storage::disk('public')->delete($food->image_path);
                }

                $food->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Food Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
