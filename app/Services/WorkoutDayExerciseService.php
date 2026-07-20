<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\WorkoutDay;
use App\Models\WorkoutDayExercise;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class WorkoutDayExerciseService
{
    use HasCode;

    public function index()
    {
        return WorkoutDayExercise::with([
            'workoutPlan',
            'workoutWeek',
            'workoutDay',
            'exercise',
        ]);
    }

    public function store(array $data): WorkoutDayExercise
    {
        try {
            return DB::transaction(function () use ($data) {

                $workoutDay = WorkoutDay::where(
                    'code',
                    $data['workout_day_code']
                )
                    ->where(
                        'workout_plan_code',
                        $data['workout_plan_code']
                    )
                    ->where(
                        'workout_week_code',
                        $data['workout_week_code']
                    )
                    ->first();

                if (! $workoutDay) {
                    throw ValidationException::withMessages([
                        'workout_day_code' => [
                            'The selected workout day does not belong to the selected workout week and workout plan.',
                        ],
                    ]);
                }

                $exercise = Exercise::where(
                    'code',
                    $data['exercise_code']
                )->firstOrFail();

//                if (
//                    $exercise->organization_code !==
//                    $workoutDay->organization_code
//                ) {
//                    throw ValidationException::withMessages([
//                        'exercise_code' => [
//                            'The selected exercise does not belong to the same organization.',
//                        ],
//                    ]);
//                }

                $workoutDayExercise = WorkoutDayExercise::create([
                    'code' => $this->generateCode('WDE', WorkoutDayExercise::class),
                    'workout_plan_code' => $data['workout_plan_code'],
                    'workout_week_code' => $data['workout_week_code'],
                    'workout_day_code' => $data['workout_day_code'],
                    'exercise_code' => $data['exercise_code'],
                    'sets' => $data['sets'] ?? null,
                    'reps' => $data['reps'] ?? null,
                    'weight' => $data['weight'] ?? null,
                    'weight_unit' => $data['weight_unit'] ?? null,
                    'duration_seconds' => $data['duration_seconds'] ?? null,
                    'rest_seconds' => $data['rest_seconds'] ?? null,
                    'distance' => $data['distance'] ?? null,
                    'distance_unit' => $data['distance_unit'] ?? null,
                    'target_percentage' => $data['target_percentage'] ?? null,
                    'target_rpe' => $data['target_rpe'] ?? null,
                    'is_optional' => $data['is_optional'] ?? false,
                    'instructions' => $data['instructions'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ]);

                return $workoutDayExercise->load([
                    'workoutPlan',
                    'workoutWeek',
                    'workoutDay',
                    'exercise',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Workout Day Exercise Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(WorkoutDayExercise $workoutDayExercise, array $data): WorkoutDayExercise
    {
        try {
            return DB::transaction(function () use (
                $workoutDayExercise,
                $data
            ) {
                $workoutDayExercise->update([
                    'sets' => $data['sets'] ?? $workoutDayExercise->sets,
                    'reps' => $data['reps'] ?? $workoutDayExercise->reps,
                    'weight' => $data['weight'] ?? $workoutDayExercise->weight,
                    'weight_unit' => $data['weight_unit'] ?? $workoutDayExercise->weight_unit,
                    'duration_seconds' => $data['duration_seconds'] ?? $workoutDayExercise->duration_seconds,
                    'rest_seconds' => $data['rest_seconds'] ?? $workoutDayExercise->rest_seconds,
                    'distance' => $data['distance'] ?? $workoutDayExercise->distance,
                    'distance_unit' => $data['distance_unit'] ?? $workoutDayExercise->distance_unit,
                    'target_percentage' => $data['target_percentage'] ?? $workoutDayExercise->target_percentage,
                    'target_rpe' => $data['target_rpe'] ?? $workoutDayExercise->target_rpe,
                    'is_optional' => $data['is_optional'] ?? $workoutDayExercise->is_optional,
                    'instructions' => $data['instructions'] ?? $workoutDayExercise->instructions,
                    'notes' => $data['notes'] ?? $workoutDayExercise->notes,
                ]);

                return $workoutDayExercise
                    ->fresh()
                    ->load([
                        'workoutPlan',
                        'workoutWeek',
                        'workoutDay',
                        'exercise',
                    ]);
            });

        } catch (\Throwable $e) {
            Log::error('Workout Day Exercise Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(WorkoutDayExercise $workoutDayExercise): bool
    {
        try {
            return DB::transaction(function () use ($workoutDayExercise) {

                $workoutDayExercise->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Workout Day Exercise Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
