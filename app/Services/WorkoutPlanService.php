<?php

namespace App\Services;

use App\Filters\WorkoutPlanFilter;
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
        return (new WorkoutPlanFilter())
            ->apply(
                WorkoutPlan::with([
                    'organization',
                    'creator',
                ])
            );
    }

    public function store(array $data, ?UploadedFile $image = null, ?UploadedFile $pdf = null): WorkoutPlan {
        try {
            return DB::transaction(function () use ($data, $image, $pdf) {
                $imagePath = null;
                $pdfPath = null;

                if ($image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'workout-plans/images',
                        $imageName,
                        'public'
                    );
                }

                if ($pdf) {
                    $pdfName = time() . '_' . $pdf->getClientOriginalName();

                    $pdfPath = $pdf->storeAs(
                        'workout-plans/pdfs',
                        $pdfName,
                        'public'
                    );
                }

                return WorkoutPlan::create([
                    'code' => $this->generateCode('WKP', WorkoutPlan::class),
                    'organization_code' => $data['organization_code'],
                    'created_by' => auth()->user()->code,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'workout_type' => $data['workout_type'],
                    'duration' => $data['duration'],
                    'duration_uom' => $data['duration_uom'],
//                    'calories' => $data['calories'],
                    'image_path' => $imagePath,
                    'pdf_file_path' => $pdfPath,
                    'status' => $data['status'],
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

    public function update(WorkoutPlan $workoutPlan, array $data, ?UploadedFile $image = null, ?UploadedFile $pdf = null): WorkoutPlan {
        try {
            return DB::transaction(function () use (
                $workoutPlan,
                $data,
                $image,
                $pdf
            ) {

                if ($image) {
                    if (
                        $workoutPlan->image_path &&
                        Storage::disk('public')->exists(
                            $workoutPlan->image_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $workoutPlan->image_path
                        );
                    }

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $data['image_path'] = $image->storeAs(
                        'workout-plans/images',
                        $imageName,
                        'public'
                    );
                }

                if ($pdf) {
                    if (
                        $workoutPlan->pdf_file_path &&
                        Storage::disk('public')->exists(
                            $workoutPlan->pdf_file_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $workoutPlan->pdf_file_path
                        );
                    }

                    $pdfName = time() . '_' . $pdf->getClientOriginalName();

                    $data['pdf_file_path'] = $pdf->storeAs(
                        'workout-plans/pdfs',
                        $pdfName,
                        'public'
                    );
                }

                $workoutPlan->update($data);

                return $workoutPlan->fresh()->load([
                    'organization',
                    'creator',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Workout Plan Update Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function destroy(WorkoutPlan $workoutPlan): bool
    {
        try {
            return DB::transaction(function () use ($workoutPlan) {

                if (
                    $workoutPlan->image_path &&
                    Storage::disk('public')->exists(
                        $workoutPlan->image_path
                    )
                ) {
                    Storage::disk('public')->delete(
                        $workoutPlan->image_path
                    );
                }

                if (
                    $workoutPlan->pdf_file_path &&
                    Storage::disk('public')->exists(
                        $workoutPlan->pdf_file_path
                    )
                ) {
                    Storage::disk('public')->delete(
                        $workoutPlan->pdf_file_path
                    );
                }

                $workoutPlan->delete();

                return true;

            });

        } catch (\Throwable $e) {

            Log::error('Workout Plan Delete Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
