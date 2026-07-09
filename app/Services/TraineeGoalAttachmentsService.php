<?php

namespace App\Services;

use App\Filters\TraineeGoalAttachmentFilter;
use App\Models\TraineeGoalsAttachments;
use App\Traits\HasCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class TraineeGoalAttachmentsService
{
    use HasCode;
    public function __construct()
    {}

    public function index()
    {
        return (new TraineeGoalAttachmentFilter())
        ->apply(
            TraineeGoalsAttachments::with([
                'traineeGoal',
                'uploader',
            ])
        );
    }

    public function store(array $data, ?UploadedFile $file): TraineeGoalsAttachments
    {
        try {
            return DB::transaction(function () use ($data, $file) {

                $path = null;
                $fileName = null;

                if ($file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();

                    $path = $file->storeAs(
                        'trainee-goals',
                        $fileName,
                        'public'
                    );
                }

                $attachment = TraineeGoalsAttachments::create([
                    'code' => $this->generateCode('TGA', TraineeGoalsAttachments::class),
                    'trainee_goal_code' => $data['trainee_goal_code'],
                    'uploaded_by' => auth()->user()->code,
                    'attachment_type' => $data['attachment_type'],
                    'file_name' => $fileName,
                    'file_path' => $path,
                    'description' => $data['description'] ?? null,
                    'uploaded_at' => now(),
                ]);

                return $attachment->load([
                    'traineeGoal',
                    'uploader',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Trainee Goal Attachment Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(TraineeGoalsAttachments $attachment, array $data, ?UploadedFile $file): TraineeGoalsAttachments
    {
        try {
//            dd($data);
            return DB::transaction(function () use ($attachment, $data, $file) {
//                dd($attachment->toArray());
                $updateData = [
                    'attachment_type' => $data['attachment_type'] ?? $attachment->attachment_type,
                    'description' => $data['description'] ?? $attachment->description,
                ];

                if ($file) {
                    if (
                        $attachment->file_path && Storage::disk('public')->exists($attachment->file_path)
                    ) {
                        Storage::disk('public')->delete($attachment->file_path);
                    }

                    $fileName = time().'_'.$file->getClientOriginalName();

                    $path = $file->storeAs(
                        'trainee-goals',
                        $fileName,
                        'public'
                    );

                    $updateData['file_name'] = $fileName;
                    $updateData['file_path'] = $path;
                    $updateData['uploaded_at'] = now();
                }
//                dd($updateData);

                $attachment->update($updateData);

//                dd(
//                    $attachment->wasChanged(),
//                    $attachment->getChanges()
//                );
                $attachment->refresh();

                return $attachment->load([
                    'traineeGoal',
                    'uploader',
                    ]);

            });

        } catch (\Throwable $e) {

            Log::error('Attachment Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(TraineeGoalsAttachments $attachment): bool
    {
        try {
            return DB::transaction(function () use ($attachment) {

                if (
                    $attachment->file_path && Storage::disk('public')->exists($attachment->file_path)
                ) {
                    Storage::disk('public')->delete($attachment->file_path);
                }

                $attachment->delete();

                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Attachment Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
