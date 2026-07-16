<?php

namespace App\Services;

//use App\Filters\GymGoalFilter;
use App\Models\GymGoals;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GymGoalsService
{
    use HasCode;

    public function __construct()
    {}

    public function index()
    {
//        return (new GymGoalFilter())
//            ->apply(
                GymGoals::with([
                    'organization',
                ]);
//            );
    }


    public function store(array $data, ?UploadedFile $image): GymGoals
    {
        try {
            return DB::transaction(function () use ($data, $image) {

                $imagePath = null;
                if($image){
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs(
                        'gym-goals',
                        $imageName,
                        'public'
                    );
                }

                $gymGoal = GymGoals::create([
                    'code' => $this->generateCode('GGL', GymGoals::class),
                    'organization_code' => $data['organization_code'],
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'description' => $data['description'] ?? null,
                    'goal_image_path' => $imagePath,
                    'goal_category' => $data['goal_category'],
                    'status' => $data['status'],
                ]);

                return $gymGoal->load([
                    'organization',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Gym Goal Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(GymGoals $gymGoal, array $data, ?UploadedFile $image): GymGoals
    {
        try {
            return DB::transaction(function () use ($gymGoal, $data, $image) {

                $updateData = [
                    'title' => $data['title'] ?? $gymGoal->title,
                    'slug' => isset($data['title'])
                        ? Str::slug($data['title'])
                        : $gymGoal->slug,
                    'description' => $data['description'] ?? $gymGoal->description,
                    'goal_category' => $data['goal_category'] ?? $gymGoal->goal_category,
                    'status' => $data['status'] ?? $gymGoal->status,
                    ];

                if ($image) {
                    if (
                        $gymGoal->goal_image_path &&
                        Storage::disk('public')->exists($gymGoal->goal_image_path)
                    ) {
                        Storage::disk('public')->delete($gymGoal->goal_image_path);
                    }

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $updateData['goal_image_path'] = $image->storeAs(
                        'gym-goals',
                        $imageName,
                        'public'
                    );
                }

                $result = $gymGoal->update($updateData);

                $gymGoal->refresh();

                return $gymGoal->load([
                    'organization',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Gym Goal Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(GymGoals $gymGoal): bool
    {
        try {
            return DB::transaction(function () use ($gymGoal) {
                $gymGoal->delete();
                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Gym Goal Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
