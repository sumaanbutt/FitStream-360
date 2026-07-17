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
                'organization',
                'trainee',
                'creator',
                'attachments',
            ])
        );
    }


    public function store(array $data): TraineeGoals
    {
        try {
            return DB::transaction(function () use ($data) {

                $user = auth()->user();
                $traineeCode = null;

                if ($data['goal_source'] === 'trainee') {
                    $trainee = Trainee::where(
                        'user_code',
                        $user->code
                    )->firstOrFail();

                    $traineeCode = $trainee->code;
                } else {
                    $traineeCode = $data['trainee_code'] ?? null;
                }

                $traineeGoal = TraineeGoals::create([
                    'code' => $this->generateCode('TGL', TraineeGoals::class),
                    'organization_code' => $data['organization_code'],
                    'trainee_code' => $traineeCode,
                    'created_by' => $user->code,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'priority' => $data['priority'] ?? 1,
                    'target_weight' => $data['target_weight'] ?? null,
                    'target_body_fat' => $data['target_body_fat'] ?? null,
                    'start_date' => $data['start_date'] ?? null,
                    'target_date' => $data['target_date'] ?? null,
                    'goal_source' => $data['goal_source'],
                    'category' => $data['category'],
                    'status' => $data['status'] ?? 'active',
                    'notes' => $data['notes'] ?? null,
                ]);
                return $traineeGoal->load([
                    'organization',
                    'trainee.user',
                    'creator',
                    'attachments',
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
                    'title' => $data['title'] ?? $traineeGoal->title,
                    'description' => $data['description'] ?? $traineeGoal->description,
                    'priority' => $data['priority'] ?? $traineeGoal->priority,
                    'target_weight' => $data['target_weight'] ?? $traineeGoal->target_weight,
                    'target_body_fat' => $data['target_body_fat'] ?? $traineeGoal->target_body_fat,
                    'start_date' => $data['start_date'] ?? $traineeGoal->start_date,
                    'target_date' => $data['target_date'] ?? $traineeGoal->target_date,
                    'category' => $data['category'] ?? $traineeGoal->category,
                    'status' => $data['status'] ?? $traineeGoal->status,
                    'notes' => $data['notes'] ?? $traineeGoal->notes,
                ]);

                $traineeGoal->refresh();

                return $traineeGoal->fresh()->load([
                    'organization',
                    'trainee.user',
                    'creator',
                    'attachments',
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

    public function assign(TraineeGoals $traineeGoal, string $traineeCode): TraineeGoal
    {
        try {
            return DB::transaction(function () use ($traineeGoal, $traineeCode) {

                $trainee = Trainee::where('code', $traineeCode)->firstOrFail();

                $traineeGoal->update([
                    'trainee_code' => $trainee->code,
                ]);

                return $traineegoal->fresh()->load([
                    'organization',
                    'trainee',
                    'creator',
                    'attachments',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Assign Failed', [
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
