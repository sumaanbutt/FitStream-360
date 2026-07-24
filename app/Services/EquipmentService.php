<?php

namespace App\Services;

use App\Models\Equipment;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EquipmentService
{
    use HasCode;

    public function index()
    {
        return Equipment::with([
            'business',
            'creator',
        ])
            ->withCount('workoutPlanEquipments')
            ->paginate(10);
    }

    public function store(array $data, ?UploadedFile $image): Equipment
    {
        try {
            return DB::transaction(function () use ($data, $image) {

                $exists = Equipment::where(
                    'business_code',
                    $data['business_code']
                )
                    ->where(
                        'name',
                        $data['name']
                    )
                    ->exists();

                if ($exists) {
                    throw ValidationException::withMessages([
                        'name' => [
                            'Equipment already exists.'
                        ],
                    ]);
                }

                $imagePath = null;

                if ($image) {
                    $imageName = time().'_'.$image->getClientOriginalName();

                    $imagePath = $image->storeAs(
                        'equipments',
                        $imageName,
                        'public'
                    );
                }

                $equipment = Equipment::create([
                    'code' => $this->generateCode('EQP', Equipment::class),
                    'business_code' => $data['business_code'],
                    'created_by' => auth()->user()->code,
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'category' => $data['category'],
                    'equipment_image_path' => $imagePath,
                    'status' => $data['status'] ?? true,
                ]);

                return $equipment->load([
                    'business',
                    'creator',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Equipment Creation Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Equipment $equipment, array $data, ?UploadedFile $image): Equipment
    {
        try {
            return DB::transaction(function () use (
                $equipment,
                $data,
                $image
            ) {

                if (
                    isset($data['name']) &&
                    $data['name'] !== $equipment->name
                ) {
                    $exists = Equipment::where(
                        'business_code',
                        $equipment->business_code
                    )
                        ->where(
                            'name',
                            $data['name']
                        )
                        ->where(
                            'code',
                            '!=',
                            $equipment->code
                        )
                        ->exists();

                    if ($exists) {
                        throw ValidationException::withMessages([
                            'name' => [
                                'Equipment already exists.'
                            ],
                        ]);
                    }
                }

                $updateData = [
                    'name' => $data['name'] ?? $equipment->name,
                    'description' => $data['description'] ?? $equipment->description,
                    'category' => $data['category'] ?? $equipment->category,
                    'status' => $data['status'] ?? $equipment->status,
                ];

                if ($image) {
                    if (
                        $equipment->image_path &&
                        Storage::disk('public')->exists(
                            $equipment->image_path
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $equipment->image_path
                        );
                    }
                    $imageName = time().'_'.$image->getClientOriginalName();

                    $updateData['image_path'] = $image->storeAs(
                        'equipments',
                        $imageName,
                        'public'
                    );
                }

                $equipment->update($updateData);

                return $equipment
                    ->fresh()
                    ->load([
                        'business',
                        'creator',
                    ]);
            });

        } catch (\Throwable $e) {
            Log::error('Equipment Update Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(Equipment $equipment): bool
    {
        try {
            return DB::transaction(function () use ($equipment) {

                if (
                    $equipment->workoutPlanEquipments()->exists()
                ) {
                    throw ValidationException::withMessages([
                        'equipment' => [
                            'Equipment is already assigned to workout plans.'
                        ],
                    ]);
                }

                if (
                    $equipment->image_path &&
                    Storage::disk('public')->exists(
                        $equipment->image_path
                    )
                ) {
                    Storage::disk('public')->delete(
                        $equipment->image_path
                    );
                }

                $equipment->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Equipment Delete Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
