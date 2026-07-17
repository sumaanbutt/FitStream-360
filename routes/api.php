<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\GymGoalsController;
use App\Http\Controllers\Api\TraineeGoalProgressController;
use App\Models\Business;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DietPlanController;
use App\Http\Controllers\Api\DietPlanWeekController;
use App\Http\Controllers\Api\DietPlanDayController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShiftScheduleController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\TraineeController;
use App\Http\Controllers\Api\TraineeGoalAttachmentController;
use App\Http\Controllers\Api\TraineeGoalController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkoutPlanController;
use App\Http\Controllers\Api\WorkoutWeekController;
use App\Http\Controllers\Api\WorkoutDayController;
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

    Route::apiResource('trainee-goals', TraineeGoalController::class);

    Route::apiResource('trainee-goal-progress', TraineeGoalProgressController::class);

    Route::apiResource('gym-goals', GymGoalsController::class);

    Route::apiResource('trainee-goals-attachments', TraineeGoalAttachmentController::class);

    Route::apiResource('attendance', AttendanceController::class);

    Route::apiResource('location', LocationController::class);

    Route::apiResource('shift-schedule', ShiftScheduleController::class);

    Route::apiResource('workout-plan', WorkoutPlanController::class);

    Route::apiResource('workout-week', WorkoutWeekController::class);

    Route::apiResource('workout-day', WorkoutDayController::class);

    Route::apiResource('diet-plan', DietPlanController::class);

    Route::apiResource('diet-plan-week', DietPlanWeekController::class);

    Route::apiResource('diet-plan-day', DietPlanDayController::class);

    Route::apiResource('product_categories', CategoryController::class);

    Route::apiResource('product_subcategories', SubCategoryController::class);

    Route::apiResource('products', ProductController::class);

    Route::apiResource('orders', OrderController::class);

    Route::apiResource('invoices', InvoiceController::class);

    Route::get('/profile', function () {
        return auth()->user();
    });
});
