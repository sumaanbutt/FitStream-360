<?php

use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\TraineeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {

    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('businesses', BusinessController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('staff', StaffController::class);
    Route::apiResource('trainees', TraineeController::class);

    Route::get('/profile', function () {
        return auth()->user();
    });

});
