<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Success', int $status = 200): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function created(mixed $data = null, string $message = 'Created successfully.'): JsonResponse {
        return self::success($data, $message, 201);
    }

    public static function error(string $message = 'Something went wrong.', int $status = 500, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    public static function notFound(string $message = 'Resource not found.'): JsonResponse {
        return self::error($message, null, 404);
    }

    public static function unauthorized(string $message = 'Unauthorized.'): JsonResponse {
        return self::error($message, null, 401);
    }

    public static function forbidden(string $message = 'Forbidden.'): JsonResponse {
        return self::error($message, null, 403);
    }

    public static function validation(mixed $errors, string $message = 'Validation failed.'): JsonResponse {
        return self::error($message, $errors, 422);
    }

    public static function deleted(string $message = 'Deleted successfully.'): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
