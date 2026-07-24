<?php

namespace App\Http\Controllers\Api;

use App\Attributes\Permission;
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

    #[Permission(['can-view-invoice'])]
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            InvoiceResource::collection(
                $this->invoiceService->index()
            ),
            'Invoices fetched successfully.'
        );
    }

    #[Permission(['can-create-invoice'])]
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

    #[Permission(['can-view-invoice'])]
    public function show(Invoice $invoice): JsonResponse
    {
        return ApiResponse::success(
            new InvoiceResource(
                $invoice->load([
                    'business',
                    'user',
                    'order',
                ])
            ),
            'Invoice fetched successfully.'
        );
    }

    #[Permission(['can-update-invoice'])]
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse {

        $invoice = $this->invoiceService->update(
            $invoice,
            $request->validated()
        );

        return ApiResponse::success(
            new InvoiceResource($invoice),
            'Invoice updated successfully.'
        );
    }

    #[Permission(['can-deactivate-invoice'])]
    public function destroy(Invoice $invoice): JsonResponse
    {
        $this->invoiceService->destroy($invoice);

        return ApiResponse::success(
            null,
            'Invoice deleted successfully.'
        );
    }
}
