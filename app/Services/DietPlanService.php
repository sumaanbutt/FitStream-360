<?php

namespace App\Services;

use App\Filters\DietPlanFilter;
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
        return (new DietPlanFilter())
            ->apply(
                DietPlan::with([
                    'organization',
                    'creator',
                ])
            );
    }

    public function store(array $data, ?UploadedFile $image = null, ?UploadedFile $pdf = null): DietPlan {
        try {
            return DB::transaction(function () use ($data, $image, $pdf) {

                $imagePath = null;
                $pdfPath = null;

                if ($image) {

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'diet-plans/images',
                        $imageName,
                        'public'
                    );
                }

                if ($pdf) {
                    $pdfName = time() . '_' . $pdf->getClientOriginalName();

                    $pdfPath = $pdf->storeAs(
                        'diet-plans/pdfs',
                        $pdfName,
                        'public'
                    );
                }

                return DietPlan::create([
                    'code' => $this->generateCode('DTP', DietPlan::class),
                    'organization_code' => $data['organization_code'],
                    'created_by' => auth()->user()->code,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'diet_type' => $data['diet_type'],
                    'duration' => $data['duration'],
                    'duration_uom' => $data['duration_uom'],
                    'calories' => $data['calories'],
                    'image_path' => $imagePath,
                    'pdf_file_path' => $pdfPath,
                    'status' => $data['status'],
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Diet Plan Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function update(DietPlan $dietPlan, array $data, ?UploadedFile $image = null, ?UploadedFile $pdf = null): DietPlan {
        try {
            return DB::transaction(function () use (
                $dietPlan,
                $data,
                $image,
                $pdf
            ) {

                if ($image) {
                    if (
                        $dietPlan->image_path &&
                        Storage::disk('public')->exists(
                            $dietPlan->image_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $dietPlan->image_path
                        );
                    }

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $data['image_path'] = $image->storeAs(
                        'diet-plans/images',
                        $imageName,
                        'public'
                    );
                }

                if ($pdf) {
                    if (
                        $dietPlan->pdf_file_path &&
                        Storage::disk('public')->exists(
                            $dietPlan->pdf_file_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $dietPlan->pdf_file_path
                        );
                    }

                    $pdfName = time() . '_' . $pdf->getClientOriginalName();

                    $data['pdf_file_path'] = $pdf->storeAs(
                        'diet-plans/pdfs',
                        $pdfName,
                        'public'
                    );
                }

                $dietPlan->update($data);

                return $dietPlan->fresh()->load([
                    'organization',
                    'creator',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Diet Plan Update Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function destroy(DietPlan $dietPlan): bool
    {
        try {
            return DB::transaction(function () use ($dietPlan) {

                if (
                    $dietPlan->image_path &&
                    Storage::disk('public')->exists(
                        $dietPlan->image_path
                    )
                ) {

                    Storage::disk('public')->delete(
                        $dietPlan->image_path
                    );

                }

                if (
                    $dietPlan->pdf_file_path &&
                    Storage::disk('public')->exists(
                        $dietPlan->pdf_file_path
                    )
                ) {

                    Storage::disk('public')->delete(
                        $dietPlan->pdf_file_path
                    );
                }

                $dietPlan->delete();

                return true;

            });

        } catch (\Throwable $e) {

            Log::error('Diet Plan Delete Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
