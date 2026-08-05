<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Analytics\AttendanceAnalyticsResource;
use App\Http\Resources\Analytics\FinanceAnalyticsResource;
use App\Http\Resources\Analytics\FitnessAnalyticsResource;
use App\Http\Resources\Analytics\InventoryAnalyticsResource;
use App\Http\Resources\Analytics\OrderAnalyticsResource;
use App\Http\Resources\Analytics\OrganizationAnalyticsResource;
use App\Http\Resources\Analytics\OverviewAnalyticsResource;
use App\Http\Resources\Analytics\UserAnalyticsResource;
use App\Services\AnalyticsService;

class AnalyticsController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {
    }

    public function overview()
    {
        return ApiResponse::success(
            new OverviewAnalyticsResource(
                $this->analyticsService->overview()
            ),
            'Overview analytics fetched successfully.'
        );
    }

    public function organization()
    {
        return ApiResponse::success(
            new OrganizationAnalyticsResource(
                $this->analyticsService->organization()
            ),
            'Organization analytics fetched successfully.'
        );
    }

    public function users()
    {
        return ApiResponse::success(
            new UserAnalyticsResource(
                $this->analyticsService->users()
            ),
            'User analytics fetched successfully.'
        );
    }

    public function attendance()
    {
        return ApiResponse::success(
            new AttendanceAnalyticsResource(
                $this->analyticsService->attendance()
            ),
            'Attendance analytics fetched successfully.'
        );
    }

    public function fitness()
    {
        return ApiResponse::success(
            new FitnessAnalyticsResource(
                $this->analyticsService->fitness()
            ),
            'Fitness analytics fetched successfully.'
        );
    }

    public function inventory()
    {
        return ApiResponse::success(
            new InventoryAnalyticsResource(
                $this->analyticsService->inventory()
            ),
            'Inventory analytics fetched successfully.'
        );
    }

    public function orders()
    {
        return ApiResponse::success(
            new OrderAnalyticsResource(
                $this->analyticsService->orders()
            ),
            'Order analytics fetched successfully.'
        );
    }

    public function finance()
    {
        return ApiResponse::success(
            new FinanceAnalyticsResource(
                $this->analyticsService->finance()
            ),
            'Finance analytics fetched successfully.'
        );
    }
}
