<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeGoalsAttachments\StoreTraineeGoalAttachmentRequest;
use App\Http\Requests\TraineeGoalsAttachments\UpdateTraineeGoalAttachmentRequest;
use App\Http\Resources\TraineeGoalAttachmentsResource;
use App\Models\TraineeGoalsAttachments;
use App\Services\TraineeGoalAttachmentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class TraineeGoalAttachmentController extends Controller
{
    public function __construct(
        protected TraineeGoalAttachmentsService $attachmentService
    ) {}

    #[Permission(['can-view-trainee-goal-attachment'])]
    public function index(): JsonResponse
    {
        $attachments = $this->attachmentService->index();

        return ApiResponse::success(
            TraineeGoalAttachmentsResource::collection($attachments),
            'Attachments fetched successfully.'
        );
    }

    #[Permission(['can-store-trainee-goal-attachment'])]
    public function store(StoreTraineeGoalAttachmentRequest $request): JsonResponse
    {
        $attachment = $this->attachmentService->store(
            $request->validated(),
            $request->file('file')
        );

        return ApiResponse::success(
            new TraineeGoalAttachmentsResource($attachment),
            'Attachment uploaded successfully.',
            201
        );
    }

    #[Permission(['can-view-trainee-goal-attachment'])]
    public function show(TraineeGoalsAttachments $traineeGoalsAttachment): JsonResponse
    {
        return ApiResponse::success(
            new TraineeGoalAttachmentsResource(
            $traineeGoalsAttachment->load([
                    'traineeGoal',
                    'uploader',
                ])
            ),
            'Attachment fetched successfully.'
        );
    }

    #[Permission(['can-update-trainee-goal-attachment'])]
    public function update(UpdateTraineeGoalAttachmentRequest $request, TraineeGoalsAttachments $traineeGoalsAttachment): JsonResponse {

        $attachment = $this->attachmentService->update(
            $traineeGoalsAttachment,
            $request->validated(),
            $request->file('file')
        );

        return ApiResponse::success(
            new TraineeGoalAttachmentsResource($attachment),
            'Attachment updated successfully.'
        );
    }

    #[Permission(['can-deactivate-trainee-goal-attachment'])]
    public function destroy(TraineeGoalsAttachments $traineeGoalsAttachment): JsonResponse
    {
        $this->attachmentService->destroy($traineeGoalsAttachment);

        return ApiResponse::success(
            null,
            'Attachment deleted successfully.'
        );
    }
}
