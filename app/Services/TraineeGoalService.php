<?php

namespace App\Services;

use App\Models\TraineeGoals;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TraineeGoalService
{
    use HasCode;

    public function __construct()
    {}

    public function index()
    {
        return TraineeGoals::with([
            'trainee.user',
            'attachments',
        ])
            ->latest()
            ->paginate(10);
    }


    public function store(array $data): TraineeGoals
    {
        try {
            return DB::transaction(function () use ($data) {

                $traineeGoal = TraineeGoals::create([

                    'code' => $this->generateCode('TGL', TraineeGoals::class),
                    'trainee_code' => $data['trainee_code'],
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'target_value' => $data['target_value'],
                    'target_unit' => $data['target_unit'],
                    'start_date' => $data['start_date'],
                    'target_date' => $data['target_date'],
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null,
                ]);

                return $traineeGoal->load([
                    'trainee.user',
                    'attachments.uploader',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(TraineeGoals $traineeGoal, array $data): TraineeGoals
    {
        try {
            return DB::transaction(function () use ($traineeGoal, $data) {
                $traineeGoal->update([
                    'trainee_code' => $data['trainee_code'] ?? $traineeGoal->trainee_code,
                    'title' => $data['title'] ?? $traineeGoal->title,
                    'description' => $data['description'] ?? $traineeGoal->description,
                    'target_value' => $data['target_value'] ?? $traineeGoal->target_value,
                    'target_unit' => $data['target_unit'] ?? $traineeGoal->target_unit,
                    'start_date' => $data['start_date'] ?? $traineeGoal->start_date,
                    'target_date' => $data['target_date'] ?? $traineeGoal->target_date,
                    'status' => $data['status'] ?? $traineeGoal->status,
                    'remarks' => $data['remarks'] ?? $traineeGoal->remarks,
                ]);

                return $traineeGoal->fresh()->load([
                    'trainee.user',
                    'attachments.uploader',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(TraineeGoals $traineeGoal): bool
    {
        try {
            return DB::transaction(function () use ($traineeGoal) {
                $traineeGoal->delete();
                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
