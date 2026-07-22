<?php

namespace App\Services;

use App\Models\DietPlanWeek;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DietPlanWeekService
{
    use HasCode;

    public function index()
    {
        return DietPlanWeek::with([
            'dietPlan',
        ])
            ->withCount('days')
            ->paginate(10);
    }

    public function store(array $data): DietPlanWeek
    {
        try {
            return DB::transaction(function () use ($data) {

                $week = DietPlanWeek::create([
                    'code' => $this->generateCode('DPW', DietPlanWeek::class),
                    'diet_plan_code' => $data['diet_plan_code'],
                    'week_number' => $data['week_number'],
                    'title' => $data['title'] ?? null,
                    'description' => $data['description'] ?? null,
                    'target_calories' => $data['target_calories'] ?? null,
                    'target_protein' => $data['target_protein'] ?? null,
                    'target_carbohydrates' => $data['target_carbohydrates'] ?? null,
                    'target_fat' => $data['target_fat'] ?? null,
                    'instructions' => $data['instructions'] ?? null,
                    'status' => $data['status'] ?? 'active',
                ]);

                return $week->load([
                    'dietPlan',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Week Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(DietPlanWeek $dietPlanWeek, array $data): DietPlanWeek
    {
        try {
            return DB::transaction(function () use (
                $dietPlanWeek,
                $data
            ) {

                $updateData = [
                    'week_number' => $data['week_number'] ?? $dietPlanWeek->week_number,
                    'title' => $data['title'] ?? $dietPlanWeek->title,
                    'description' => $data['description'] ?? $dietPlanWeek->description,
                    'target_calories' => $data['target_calories'] ?? $dietPlanWeek->target_calories,
                    'target_protein' => $data['target_protein'] ?? $dietPlanWeek->target_protein,
                    'target_carbohydrates' => $data['target_carbohydrates'] ?? $dietPlanWeek->target_carbohydrates,
                    'target_fat' => $data['target_fat'] ?? $dietPlanWeek->target_fat,
                    'instructions' => $data['instructions'] ?? $dietPlanWeek->instructions,
                    'status' => $data['status'] ?? $dietPlanWeek->status,
                ];

                $dietPlanWeek->update($updateData);

                return $dietPlanWeek
                    ->fresh()
                    ->load([
                        'dietPlan',
                    ]);

            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Week Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(DietPlanWeek $dietPlanWeek): bool {
        try {
            return DB::transaction(function () use ($dietPlanWeek) {

                $dietPlanWeek->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Diet Plan Week Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
