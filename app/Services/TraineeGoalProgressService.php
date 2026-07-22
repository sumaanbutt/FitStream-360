<?php

namespace App\Services;

//use App\Filters\TraineeGoalProgressFilter;
use App\Models\TraineeGoalProgress;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TraineeGoalProgressService
{
    use HasCode;

    public function __construct()
    {
    }

    public function index()
    {
//        return (new TraineeGoalProgressFilter())
//            ->apply(
                TraineeGoalProgress::with([
                    'traineeGoal',
                ])
                ->paginate(10);
//            );
    }

    public function store(array $data): TraineeGoalProgress
    {
        try {
            return DB::transaction(function () use ($data) {

                $progress = TraineeGoalProgress::create([
                    'code' => $this->generateCode('TGP', TraineeGoalProgress::class),
                    'trainee_goal_code' => $data['trainee_goal_code'],
                    'weight' => $data['weight'] ?? null,
                    'body_fat' => $data['body_fat'] ?? null,
                    'muscle_mass' => $data['muscle_mass'] ?? null,
                    'chest' => $data['chest'] ?? null,
                    'waist' => $data['waist'] ?? null,
                    'hips' => $data['hips'] ?? null,
                    'arms' => $data['arms'] ?? null,
                    'thighs' => $data['thighs'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'recorded_at' => $data['recorded_at'],
                ]);

                return $progress->load([
                    'traineeGoal',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Progress Creation Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(TraineeGoalProgress $progress, array $data): TraineeGoalProgress
    {
        try {
            return DB::transaction(function () use ($progress, $data) {

                $progress->update([
                    'trainee_goal_code' => $data['trainee_goal_code'] ?? $progress->trainee_goal_code,
                    'weight' => $data['weight'] ?? $progress->weight,
                    'body_fat' => $data['body_fat'] ?? $progress->body_fat,
                    'muscle_mass' => $data['muscle_mass'] ?? $progress->muscle_mass,
                    'chest' => $data['chest'] ?? $progress->chest,
                    'waist' => $data['waist'] ?? $progress->waist,
                    'hips' => $data['hips'] ?? $progress->hips,
                    'arms' => $data['arms'] ?? $progress->arms,
                    'thighs' => $data['thighs'] ?? $progress->thighs,
                    'notes' => $data['notes'] ?? $progress->notes,
                    'recorded_at' => $data['recorded_at'] ?? $progress->recorded_at,
                ]);

                return $progress->fresh()->load([
                    'traineeGoal',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Progress Update Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(TraineeGoalProgress $progress): bool
    {
        try {
            return DB::transaction(function () use ($progress) {

                $progress->delete();

                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Progress Delete Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
