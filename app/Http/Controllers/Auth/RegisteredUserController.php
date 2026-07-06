<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email',],
            'phone' => ['nullable','string','max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(),],
            'status' => ['required','boolean'],
        ]);

        $user = $this->userService->register($validated);

        $token = JWTAuth::fromUser($user);

        return ApiResponse::success([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'User registered successfully.', 201);
    }
}

