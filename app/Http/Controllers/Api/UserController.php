<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
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

    #[Permission(['can-view-user'])]
    public function index()
    {
        $users = $this->userService->index();

        return ApiResponse::success(
            UserResource::collection($users),
            'Users retrieved successfully.'
        );
    }

    #[Permission(['can-create-user'])]
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

    #[Permission(['can-view-user'])]
    public function show(User $user)
    {
        return ApiResponse::success(
            new UserResource($user),
            'User retrieved successfully.'
        );
    }

    #[Permission(['can-update-user'])]
    public function update(UpdateUserRequest $request, User $user) {

        $user = $this->userService->update($user, $request->validated());

        return ApiResponse::success(
            new UserResource($user),
            'User updated successfully.'
        );
    }

    #[Permission(['can-deactivate-user'])]
    public function destroy(User $user)
    {
        $this->userService->destroy($user);

        return ApiResponse::deleted(
            'User deleted successfully.'
        );
    }
}
