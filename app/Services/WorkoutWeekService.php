<?php

namespace App\Services;

use App\Models\WorkoutWeek;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkoutWeekService
{
    use HasCode;

    public function index()
    {
        return WorkoutWeek::with([
            'workoutPlan',
        ])
            ->withCount('days')
            ->latest()
            ->paginate();
    }

    public function store(array $data): WorkoutWeek
    {
        try {

            return DB::transaction(function () use ($data) {

                $week = WorkoutWeek::create([
                    'code' => $this->generateCode('WWK', WorkoutWeek::class),
                    'workout_plan_code' => $data['workout_plan_code'],
                    'week_number' => $data['week_number'],
                    'title' => $data['title'] ?? null,
                    'description' => $data['description'] ?? null,
                    'instructions' => $data['instructions'] ?? null,
                    'status' => $data['status'] ?? 'active',
                ]);

                return $week->load([
                    'workoutPlan',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Workout Week Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(WorkoutWeek $workoutWeek, array $data): WorkoutWeek {

        try {
            return DB::transaction(function () use ($workoutWeek, $data) {

                $updateData = [
                    'week_number' => $data['week_number'] ?? $workoutWeek->week_number,
                    'title' => $data['title'] ?? $workoutWeek->title,
                    'description' => $data['description'] ?? $workoutWeek->description,
                    'instructions' => $data['instructions'] ?? $workoutWeek->instructions,
                    'status' => $data['status'] ?? $workoutWeek->status,
                ];

                $workoutWeek->update($updateData);

                return $workoutWeek
                    ->fresh()
                    ->load([
                        'workoutPlan',
                    ]);

            });

        } catch (\Throwable $e) {

            Log::error('Workout Week Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(WorkoutWeek $workoutWeek): bool {

        try {
            return DB::transaction(function () use ($workoutWeek) {

                $workoutWeek->delete();

                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Workout Week Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
