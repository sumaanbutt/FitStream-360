<?php

namespace App\Services;

use App\Models\Exercise;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ExerciseService
{
    use HasCode;

    public function index()
    {
        return Exercise::with([
            'organization',
            'creator',
        ])
            ->withCount('workoutDayExercises');
    }

    public function store(array $data, ?UploadedFile $image): Exercise
    {
        try {
            return DB::transaction(function () use ($data, $image) {

                $exists = Exercise::where(
                    'organization_code',
                    $data['organization_code']
                )
                    ->whereRaw(
                        'LOWER(name) = ?',
                        [strtolower($data['name'])]
                    )
                    ->exists();

                if ($exists) {
                    throw ValidationException::withMessages([
                        'name' => [
                            'Exercise already exists.'
                        ],
                    ]);
                }

                $imagePath = null;

                if ($image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'exercises',
                        $imageName,
                        'public'
                    );
                }

                $exercise = Exercise::create([
                    'code' => $this->generateCode('EXR', Exercise::class),
                    'organization_code' => $data['organization_code'],
                    'created_by' => auth()->user()->code,
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'exercise_type' => $data['exercise_type'],
                    'primary_muscle' => $data['primary_muscle'],
                    'secondary_muscles' => $data['secondary_muscles'] ?? null,
                    'difficulty' => $data['difficulty'],
                    'instructions' => $data['instructions'] ?? null,
                    'video_url' => $data['video_path'] ?? null,
                    'image_path' => $imagePath,
                    'status' => $data['status'] ?? true,
                ]);

                return $exercise->load([
                    'organization',
                    'creator',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Exercise Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Exercise $exercise, array $data, ?UploadedFile $image): Exercise
    {
        try {
            return DB::transaction(function () use (
                $exercise,
                $data,
                $image
            ) {

                if (
                    isset($data['name']) &&
                    strtolower($data['name']) !== strtolower($exercise->name)
                ) {
                    $exists = Exercise::where(
                        'organization_code',
                        $exercise->organization_code
                    )
                        ->whereRaw(
                            'LOWER(name) = ?',
                            [strtolower($data['name'])]
                        )
                        ->where(
                            'code',
                            '!=',
                            $exercise->code
                        )
                        ->exists();

                    if ($exists) {
                        throw ValidationException::withMessages([
                            'name' => [
                                'Exercise already exists.'
                            ],
                        ]);
                    }
                }

                $updateData = [
                    'name' => $data['name'] ?? $exercise->name,
                    'description' => $data['description'] ?? $exercise->description,
                    'exercise_type' => $data['exercise_type'] ?? $exercise->exercise_type,
                    'primary_muscle' => $data['primary_muscle'] ?? $exercise->primary_muscle,
                    'secondary_muscles' => $data['secondary_muscles'] ?? $exercise->secondary_muscles,
                    'difficulty' => $data['difficulty'] ?? $exercise->difficulty,
                    'instructions' => $data['instructions'] ?? $exercise->instructions,
                    'video_path' => $data['video_path'] ?? $exercise->video_path,
                    'status' => $data['status'] ?? $exercise->status,
                ];

                if ($image) {
                    if (
                        $exercise->image_path &&
                        Storage::disk('public')->exists(
                            $exercise->image_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $exercise->image_path
                        );
                    }
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $updateData['image_path'] = $image->storeAs(
                        'exercises',
                        $imageName,
                        'public'
                    );
                }

                $exercise->update($updateData);

                return $exercise
                    ->fresh()
                    ->load([
                        'organization',
                        'creator',
                    ]);

            });

        } catch (\Throwable $e) {
            Log::error('Exercise Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(Exercise $exercise): bool
    {
        try {
            return DB::transaction(function () use ($exercise) {

                if (
                    $exercise->workoutDayExercises()->exists()
                ) {
                    throw ValidationException::withMessages([
                        'exercise' => [
                            'Exercise is already assigned to a workout day.'
                        ],
                    ]);
                }

                if (
                    $exercise->image_path &&
                    Storage::disk('public')->exists(
                        $exercise->image_path
                    )
                ) {
                    Storage::disk('public')->delete(
                        $exercise->image_path
                    );
                }

                $exercise->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Exercise Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
