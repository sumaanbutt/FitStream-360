<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    #[Authorize('viewAny', User::class)]
    public function index()
    {
        $users = $this->userService->index();

        return ApiResponse::success(
            UserResource::collection($users),
            'Users retrieved successfully.'
        );
    }

    #[Authorize('create', User::class)]
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new UserResource($user),
            'User created successfully.'
        );
    }

    #[Authorize('view', User::class)]
    public function show(User $user)
    {
        return ApiResponse::success(
            new UserResource($user),
            'User retrieved successfully.'
        );
    }

    #[Authorize('update', User::class)]
    public function update(UpdateUserRequest $request, User $user) {

        $user = $this->userService->update($user, $request->validated());

        return ApiResponse::success(
            new UserResource($user),
            'User updated successfully.'
        );
    }

    #[Authorize('delete', User::class)]
    public function destroy(User $user)
    {
        $this->userService->destroy($user);

        return ApiResponse::deleted(
            'User deleted successfully.'
        );
    }
}
