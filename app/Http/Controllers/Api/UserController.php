<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->index();

        return ApiResponse::success(
            UserResource::collection($users),
            'Users retrieved successfully.'
        );
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = $this->userService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new UserResource($user),
            'User created successfully.'
        );
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return ApiResponse::success(
            new UserResource($user),
            'User retrieved successfully.'
        );
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $this->authorize('update', $user);

        $user = $this->userService->update(
            $user,
            $request->validated()
        );

        return ApiResponse::success(
            new UserResource($user),
            'User updated successfully.'
        );
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->destroy($user);

        return ApiResponse::deleted(
            'User deleted successfully.'
        );
    }
}
