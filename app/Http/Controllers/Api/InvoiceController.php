<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $invoiceService
    ) {}

    #[Authorize('viewAny', Invoice::class)]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            InvoiceResource::collection(
                $this->invoiceService->index()
            ),
            'Invoices fetched successfully.'
        );
    }

    #[Authorize('create', Invoice::class)]
    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $invoice = $this->invoiceService->store(
            $request->validated()
        );

        return ApiResponse::success(
            new InvoiceResource($invoice),
            'Invoice created successfully.',
            201
        );
    }

    #[Authorize('view', Invoice::class)]
    public function show(Invoice $invoice): JsonResponse
    {
        return ApiResponse::success(
            new InvoiceResource(
                $invoice->load([
                    'organization',
                    'business',
                    'user',
                    'order',
                ])
            ),
            'Invoice fetched successfully.'
        );
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse {

        $this->authorize('update', $invoice);

        $invoice = $this->invoiceService->update(
            $invoice,
            $request->validated()
        );

        return ApiResponse::success(
            new InvoiceResource($invoice),
            'Invoice updated successfully.'
        );
    }

    public function destroy(Invoice $invoice): JsonResponse
    {
        $this->authorize('delete', $invoice);

        $this->invoiceService->destroy($invoice);

        return ApiResponse::success(
            null,
            'Invoice deleted successfully.'
        );
    }
}
