<?php

namespace App\Services;

use App\Models\WorkoutDay;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkoutDayService
{
    use HasCode;

    public function index()
    {
        return WorkoutDay::with([
            'workoutPlan',
            'workoutWeek',
            ])
            ->paginate(10);
    }

    public function store(array $data): WorkoutDay
    {
        try {
            return DB::transaction(function () use ($data) {

                $week = WorkoutWeek::where('code', $data['workout_week_code'])
                    ->where('workout_plan_code', $data['workout_plan_code'])
                    ->first();

                if (! $week) {
                    throw ValidationException::withMessages([
                        'workout_week_code' => 'The selected workout week does not belong to the specified workout plan.',
                    ]);
                }

                $workoutDay = WorkoutDay::create([
                    'code' => $this->generateCode('WDY', WorkoutDay::class),
                    'workout_plan_code' => $data['workout_plan_code'],
                    'workout_week_code' => $data['workout_week_code'],
                    'day_number' => $data['day_number'],
                    'day_name' => $data['day_name'],
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'instructions' => $data['instructions'] ?? null,
                    'estimated_duration' => $data['estimated_duration'] ?? null,
                    'is_rest_day' => $data['is_rest_day'] ?? false,
                    'status' => $data['status'] ?? 'active',
                ]);

                return $workoutDay->load([
                    'workoutPlan',
                    'workoutWeek',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Workout Day Creation Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(WorkoutDay $workoutDay, array $data): WorkoutDay {

        try {
            return DB::transaction(function () use ($workoutDay, $data) {

                $week = WorkoutWeek::where('code', $data['workout_week_code'])
                    ->where('workout_plan_code', $data['workout_plan_code'])
                    ->first();

                if (! $week) {
                    throw ValidationException::withMessages([
                        'workout_week_code' => 'The selected workout week does not belong to the specified workout plan.',
                    ]);
                }

                $updateData = [
                    'day_number' => $data['day_number'] ?? $workoutDay->day_number,
                    'day_name' => $data['day_name'] ?? $workoutDay->day_name,
                    'title' => $data['title'] ?? $workoutDay->title,
                    'description' => $data['description'] ?? $workoutDay->description,
                    'instructions' => $data['instructions'] ?? $workoutDay->instructions,
                    'estimated_duration' => $data['estimated_duration'] ?? $workoutDay->estimated_duration,
                    'is_rest_day' => $data['is_rest_day'] ?? $workoutDay->is_rest_day,
                    'status' => $data['status'] ?? $workoutDay->status,
                ];

                $workoutDay->update($updateData);

                return $workoutDay
                    ->fresh()
                    ->load([
                        'workoutPlan',
                        'workoutWeek',
                    ]);

            });

        } catch (\Throwable $e) {

            Log::error('Workout Day Update Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(WorkoutDay $workoutDay): bool {

        try {
            return DB::transaction(function () use ($workoutDay) {

                $workoutDay->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Workout Day Delete Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
