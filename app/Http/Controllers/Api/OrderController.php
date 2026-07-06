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

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Order::class);

        $orders = $this->orderService->index();

        return ApiResponse::success(
            OrderResource::collection($orders),
            'Orders fetched successfully.'
        );
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $this->authorize('create', Order::class);

        $order = $this->orderService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new OrderResource($order),
            'Order created successfully.',
            201
        );
    }

    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return ApiResponse::success(
            new OrderResource(
                $order->load([
                    'organization',
                    'business',
                    'user',
//                    'items.product',
                    'invoice',
                ])
            ),
            'Order fetched successfully.'
        );
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse {

        $this->authorize('update', $order);

        $order = $this->orderService->update(
            $order,
            $request->validated()
        );

        return ApiResponse::success(
            new OrderResource($order),
            'Order updated successfully.'
        );
    }

    public function destroy(Order $order): JsonResponse
    {
        $this->authorize('delete', $order);

        $this->orderService->destroy($order);

        return ApiResponse::success(
            null,
            'Order deleted successfully.'
        );
    }
}
