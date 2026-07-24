<?php

namespace App\Services;

use App\Models\DietPlan;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DietPlanService
{
    use HasCode;

    public function index()
    {
        return DietPlan::with([
            'business',
            'creator',
        ])
            ->withCount('weeks')
            ->paginate(10);
    }

    public function store(array $data, ?UploadedFile $image): DietPlan
    {
        try {
            return DB::transaction(function () use ($data, $image) {

                $imagePath = null;

                if ($image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'diet-plans',
                        $imageName,
                        'public'
                    );
                }

                $dietPlan = DietPlan::create([
                    'code' => $this->generateCode('DPL', DietPlan::class),
                    'business_code' => $data['business_code'],
                    'created_by' => auth()->user()->code,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'goal' => $data['goal'],
                    'diet_type' => $data['diet_type'],
                    'level' => $data['level'],
                    'gender' => $data['gender'],
                    'duration_weeks' => $data['duration_weeks'],
                    'meals_per_day' => $data['meals_per_day'],
                    'target_calories' => $data['target_calories'] ?? null,
                    'target_protein' => $data['target_protein'] ?? null,
                    'target_carbohydrates' => $data['target_carbohydrates'] ?? null,
                    'target_fat' => $data['target_fat'] ?? null,
                    'price' => $data['price'],
                    'currency' => $data['currency'],
                    'cover_image_path' => $imagePath,
                    'status' => $data['status'] ?? 'draft',
                ]);

                return $dietPlan->load([
                    'business',
                    'creator',
                ]);

            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Creation Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(DietPlan $dietPlan, array $data, ?UploadedFile $image): DietPlan
    {
        try {
            return DB::transaction(function () use (
                $dietPlan,
                $data,
                $image
            ) {

                $updateData = [
                    'title' => $data['title'] ?? $dietPlan->title,
                    'description' => $data['description'] ?? $dietPlan->description,
                    'goal' => $data['goal'] ?? $dietPlan->goal,
                    'diet_type' => $data['diet_type'] ?? $dietPlan->diet_type,
                    'level' => $data['level'] ?? $dietPlan->level,
                    'gender' => $data['gender'] ?? $dietPlan->gender,
                    'duration_weeks' => $data['duration_weeks'] ?? $dietPlan->duration_weeks,
                    'meals_per_day' => $data['meals_per_day'] ?? $dietPlan->meals_per_day,
                    'target_calories' => $data['target_calories'] ?? $dietPlan->target_calories,
                    'target_protein' => $data['target_protein'] ?? $dietPlan->target_protein,
                    'target_carbohydrates' => $data['target_carbohydrates'] ?? $dietPlan->target_carbohydrates,
                    'target_fat' => $data['target_fat'] ?? $dietPlan->target_fat,
                    'price' => $data['price'] ?? $dietPlan->price,
                    'currency' => $data['currency'] ?? $dietPlan->currency,
                    'status' => $data['status'] ?? $dietPlan->status,
                ];

                if ($image) {
                    if (
                        $dietPlan->cover_image_path &&
                        Storage::disk('public')->exists(
                            $dietPlan->cover_image_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $dietPlan->cover_image_path
                        );
                    }
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $updateData['cover_image_path'] = $image->storeAs(
                        'diet-plans',
                        $imageName,
                        'public'
                    );
                }

                $dietPlan->update($updateData);

                return $dietPlan
                    ->fresh()
                    ->load([
                        'business',
                        'creator',
                    ]);

            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Update Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(DietPlan $dietPlan): bool
    {
        try {
            return DB::transaction(function () use ($dietPlan) {

                if (
                    $dietPlan->cover_image_path &&
                    Storage::disk('public')->exists(
                        $dietPlan->cover_image_path
                    )
                ) {
                    Storage::disk('public')->delete(
                        $dietPlan->cover_image_path
                    );
                }

                $dietPlan->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Delete Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
