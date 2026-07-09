<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use JetBrains\PhpStorm\ArrayShape;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    #[Authorize('viewAny', Order::class)]
    public function index(): JsonResponse
    {
        $orders = $this->orderService->index();

        return ApiResponse::success(
            OrderResource::collection($orders),
            'Orders fetched successfully.'
        );
    }

    #[Authorize('create', Order::class)]
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new OrderResource($order),
            'Order created successfully.',
            201
        );
    }

    #[Authorize('view', Order::class)]
    public function show(Order $order): JsonResponse
    {
        return ApiResponse::success(
            new OrderResource(
                $order->load([
                    'organization',
                    'business',
                    'user',
                    'invoice',
                ])
            ),
            'Order fetched successfully.'
        );
    }

    #[Authorize('update', Order::class)]
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse {

        $order = $this->orderService->update(
            $order,
            $request->validated()
        );

        return ApiResponse::success(
            new OrderResource($order),
            'Order updated successfully.'
        );
    }

    #[Authorize('delete', Order::class)]
    public function destroy(Order $order): JsonResponse
    {
        $this->orderService->destroy($order);

        return ApiResponse::success(
            null,
            'Order deleted successfully.'
        );
    }
}
