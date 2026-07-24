<?php

namespace App\Services;

use App\Models\WorkoutPlan;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WorkoutPlanService
{
    use HasCode;

    public function index()
    {
        return WorkoutPlan::with([
            'business',
            'creator',
        ])
            ->withCount('weeks')
            ->paginate();
    }

    public function store(array $data, ?UploadedFile $image): WorkoutPlan
    {
        try {
            return DB::transaction(function () use ($data, $image) {

                $imagePath = null;

                if ($image) {

                    $imageName = time().'_'.$image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'workout-plans',
                        $imageName,
                        'public'
                    );
                }

                $workoutPlan = WorkoutPlan::create([
                    'code' => $this->generateCode('WPL', WorkoutPlan::class),
                    'business_code' => $data['business_code'],
                    'created_by' => auth()->user()->code,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'goal' => $data['goal'],
                    'level' => $data['level'],
                    'gender' => $data['gender'],
                    'duration_weeks' => $data['duration_weeks'],
                    'days_per_week' => $data['days_per_week'],
                    'estimated_minutes_per_day' => $data['estimated_minutes_per_day'] ?? null,
                    'requires_gym' => $data['requires_gym'],
                    'price' => $data['price'],
                    'currency' => $data['currency'],
                    'cover_image_path' => $imagePath,
                    'status' => $data['status'] ?? 'draft',
                ]);

                return $workoutPlan->load([
                    'business',
                    'creator',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Workout Plan Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(WorkoutPlan $workoutPlan, array $data, ?UploadedFile $image): WorkoutPlan {
        try {
            return DB::transaction(function () use (
                $workoutPlan,
                $data,
                $image
            ) {

                $updateData = [
                    'title' => $data['title'] ?? $workoutPlan->title,
                    'description' => $data['description'] ?? $workoutPlan->description,
                    'goal' => $data['goal'] ?? $workoutPlan->goal,
                    'level' => $data['level'] ?? $workoutPlan->level,
                    'gender' => $data['gender'] ?? $workoutPlan->gender,
                    'duration_weeks' => $data['duration_weeks'] ?? $workoutPlan->duration_weeks,
                    'days_per_week' => $data['days_per_week'] ?? $workoutPlan->days_per_week,
                    'estimated_minutes_per_day' => $data['estimated_minutes_per_day'] ?? $workoutPlan->estimated_minutes_per_day,
                    'requires_gym' => $data['requires_gym'] ?? $workoutPlan->requires_gym,
                    'price' => $data['price'] ?? $workoutPlan->price,
                    'currency' => $data['currency'] ?? $workoutPlan->currency,
                    'status' => $data['status'] ?? $workoutPlan->status,
                ];

                if ($image) {

                    if (
                        $workoutPlan->cover_image_path &&
                        Storage::disk('public')->exists(
                            $workoutPlan->cover_image_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $workoutPlan->cover_image_path
                        );
                    }

                    $imageName = time().'_'.$image->getClientOriginalName();

                    $updateData['cover_image_path'] =
                        $image->storeAs(
                            'workout-plans',
                            $imageName,
                            'public'
                        );
                }

                $workoutPlan->update($updateData);

                return $workoutPlan
                    ->fresh()
                    ->load([
                        'business',
                        'creator',
                    ]);

            });

        } catch (\Throwable $e) {

            Log::error('Workout Plan Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(WorkoutPlan $workoutPlan): bool
    {
        try {

            return DB::transaction(function () use ($workoutPlan) {

                if (
                    $workoutPlan->cover_image_path &&
                    Storage::disk('public')->exists(
                        $workoutPlan->cover_image_path
                    )
                ) {
                    Storage::disk('public')->delete(
                        $workoutPlan->cover_image_path
                    );
                }

                $workoutPlan->delete();

                return true;

            });

        } catch (\Throwable $e) {

            Log::error('Workout Plan Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
