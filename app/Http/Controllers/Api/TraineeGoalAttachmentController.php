<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeGoalsAttachments\StoreTraineeGoalAttachmentRequest;
use App\Http\Requests\TraineeGoalsAttachments\UpdateTraineeGoalAttachmentRequest;
use App\Http\Resources\TraineeGoalAttachmentsResource;
use App\Models\TraineeGoalsAttachments;
use App\Services\TraineeGoalAttachmentsService;
use Illuminate\Http\JsonResponse;

class TraineeGoalAttachmentController extends Controller
{
    public function __construct(
        protected TraineeGoalAttachmentsService $attachmentService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', TraineeGoalsAttachments::class);

        $attachments = $this->attachmentService->index();

        return ApiResponse::success(
            TraineeGoalAttachmentsResource::collection($attachments),
            'Attachments fetched successfully.'
        );
    }

    public function store(StoreTraineeGoalAttachmentRequest $request): JsonResponse
    {
        $this->authorize('create', TraineeGoalsAttachments::class);

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

    public function show(TraineeGoalsAttachments $traineeGoalAttachment): JsonResponse
    {
        $this->authorize('view', $traineeGoalAttachment);

        return ApiResponse::success(
            new TraineeGoalAttachmentsResource(
            $traineeGoalAttachment->load([
                    'traineeGoal',
                    'uploader',
                ])
            ),
            'Attachment fetched successfully.'
        );
    }

    public function update(UpdateTraineeGoalAttachmentRequest $request, TraineeGoalsAttachments $traineeGoalAttachment): JsonResponse {

        $this->authorize('update', $traineeGoalAttachment);

        $attachment = $this->attachmentService->update(
            $traineeGoalAttachment,
            $request->validated(),
            $request->file('file')
        );

        return ApiResponse::success(
            new TraineeGoalAttachmentsResource($attachment),
            'Attachment updated successfully.'
        );
    }

    public function destroy(TraineeGoalsAttachments $traineeGoalAttachment): JsonResponse
    {
        $this->authorize('delete', $traineeGoalAttachment);
        $this->attachmentService->destroy($traineeGoalAttachment);

        return ApiResponse::success(
            null,
            'Attachment deleted successfully.'
        );
    }
}
