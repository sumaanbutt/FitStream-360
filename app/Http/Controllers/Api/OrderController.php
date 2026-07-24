<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
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

    #[Permission(['can-view-order'])]
    public function index(): JsonResponse
    {
        $orders = $this->orderService->index();

        return ApiResponse::success(
            OrderResource::collection($orders),
            'Orders fetched successfully.'
        );
    }

    #[Permission(['can-create-order'])]
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

    #[Permission(['can-view-order'])]
    public function show(Order $order): JsonResponse
    {
        return ApiResponse::success(
            new OrderResource(
                $order->load([
                    'business',
                    'user',
                    'invoice',
                ])
            ),
            'Order fetched successfully.'
        );
    }

    #[Permission(['can-update-order'])]
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

    #[Permission(['can-deactivate-order'])]
    public function destroy(Order $order): JsonResponse
    {
        $this->orderService->destroy($order);

        return ApiResponse::success(
            null,
            'Order deleted successfully.'
        );
    }
}
