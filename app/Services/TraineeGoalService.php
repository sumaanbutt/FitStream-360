<?php

namespace App\Services;

use App\Filters\TraineeGoalFilter;
use App\Models\Trainee;
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
        return (new TraineeGoalFilter())
        ->apply(
            TraineeGoals::with([
                'trainee.user',
                'gymGoal',
                'attachments',
            ])
        );
    }


    public function store(array $data): TraineeGoals
    {
        try {
            return DB::transaction(function () use ($data) {

                $trainee = Trainee::where('code', $data['trainee_code'])->firstOrFail();

                $traineeGoal = TraineeGoals::create([
                    'code' => $this->generateCode('TGL', TraineeGoals::class),
                    'trainee_code' => $trainee->code,
                    'gym_goal_code' => $data['gym_goal_code'],
                    'user_code' => $trainee->user_code ?? null,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'priority' => $data['priority'] ?? 1,
                    'target_weight' => $data['target_weight'] ?? null,
                    'target_body_fat' => $data['target_body_fat'] ?? null,
                    'start_date' => $data['start_date'],
                    'target_date' => $data['target_date'],
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                ]);

                return $traineeGoal->load([
                    'trainee.user',
                    'gymGoal',
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

                $updateData = [
                    'trainee_code' => $data['trainee_code'] ?? $traineeGoal->trainee_code,
                    'gym_goal_code' => $data['gym_goal_code'] ?? $traineeGoal->gym_goal_code,
                    'user_code' => $data['user_code'] ?? $traineeGoal->user_code,
                    'title' => $data['title'] ?? $traineeGoal->title,
                    'description' => $data['description'] ?? $traineeGoal->description,
                    'priority' => $data['priority'] ?? $traineeGoal->priority,
                    'target_weight' => $data['target_weight'] ?? $traineeGoal->target_weight,
                    'target_body_fat' => $data['target_body_fat'] ?? $traineeGoal->target_body_fat,
                    'start_date' => $data['start_date'] ?? $traineeGoal->start_date,
                    'target_date' => $data['target_date'] ?? $traineeGoal->target_date,
                    'status' => $data['status'] ?? $traineeGoal->status,
                    'notes' => $data['notes'] ?? $traineeGoal->notes,
                ];

                if (isset($data['trainee_code'])) {

                    $trainee = Trainee::where('code', $data['trainee_code'])->firstOrFail();

                    $updateData['trainee_code'] = $trainee->code;
                    $updateData['user_code'] = $trainee->user_code;
                }

                $traineeGoal->update($updateData);

                return $traineeGoal->fresh()->load([
                    'trainee.user',
                    'gymGoal',
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
