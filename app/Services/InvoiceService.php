<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    use HasCode;

    public function index()
    {
        return Invoice::with([
            'organization',
            'business',
            'user',
            'order',
        ])
            ->latest()
            ->paginate(10);
    }

    public function createFromOrder(Order $order): Invoice
    {
        try {
            return DB::transaction(function () use ($order) {
                if (
                    Invoice::where(
                        'order_code',
                        $order->code
                    )->exists()
                ) {
                    throw new \Exception('Invoice already exists for this order.');
                }

                $invoice = Invoice::create([

                    'code' => $this->generateCode('INV', Invoice::class),
                    'organization_code' => $order->organization_code,
                    'business_code' => $order->business_code,
                    'user_code' => $order->user_code,
                    'order_code' => $order->code,
                    'invoice_type' => 'order',
                    'subtotal' => $order->subtotal,
                    'discount' => $order->discount,
                    'tax' => $order->tax,
                    'total' => $order->total,
                    'payment_method' => $order->payment_method,
                    'payment_status' => $order->payment_status,
                    'status' => 'issued',
                ]);

                return $invoice->load([
                    'organization',
                    'business',
                    'user',
                    'order',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Invoice Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        try {
            return DB::transaction(function () use ($invoice, $data) {

                $invoice->update([
                    'payment_method' => $data['payment_method'] ?? $invoice->payment_method,
                    'payment_status' => $data['payment_status'] ?? $invoice->payment_status,
                    'status' => $data['status'] ?? $invoice->status,
                ]);

                return $invoice->fresh()->load([
                    'organization',
                    'business',
                    'user',
                    'order',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Invoice Update Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function destroy(Invoice $invoice): bool
    {
        try {
            return DB::transaction(function () use ($invoice) {

                $invoice->delete();

                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Invoice Delete Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

}
