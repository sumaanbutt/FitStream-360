<?php

namespace App\Services;

use App\Filters\OrderFilter;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    use HasCode;

    public function __construct()
    {}

    public function index()
    {
        return (new OrderFilter())
            ->apply(Order::with([
                'organization',
                'business',
                'user',
                'items.product',
                'invoice',
            ])
        );
    }

    public function store(array $data): Order
    {
        try {
            return DB::transaction(function () use ($data) {

                $subtotal = 0;

                foreach ($data['items'] as $item) {

                    $product = Product::where(
                        'code',
                        $item['product_code']
                    )->firstOrFail();

                    if ($product->quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$product->name}.");
                    }
                    $subtotal += $product->selling_price * $item['quantity'];
                }

                $discount = $data['discount'] ?? 0;
                $tax = $data['tax'] ?? 0;
                $total = ($subtotal - $discount) + $tax;

                $order = Order::create([
                    'code' => $this->generateCode('ORD', Order::class),
                    'organization_code' => $data['organization_code'],
                    'business_code' => $data['business_code'],
                    'user_code' => $data['user_code'] ?? null,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'pending',
                    'status' => 'completed',
                ]);

                foreach ($data['items'] as $item) {

                    $product = Product::where(
                        'code',
                        $item['product_code']
                    )->first();

                    OrderItem::create([

                        'code' => $this->generateCode('ODI', OrderItem::class),
                        'order_code' => $order->code,
                        'product_code' => $product->code,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->selling_price,
                        'discount' => 0,
                        'subtotal' =>
                            $product->selling_price *
                            $item['quantity'],
                    ]);

                    $product->decrement('quantity', $item['quantity']);
                }

                $invoice = Invoice::create([
                    'code' => $this->generateCode('INV', Invoice::class),
                    'order_code' => $order->code,
                    'organization_code' => $order->organization_code,
                    'user_code' => $order->trainee_code,
                    'invoice_number' => 'INV-'.time(),
                    'invoice_type' => 'POS',
                    'payment_status' => 'pending',
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total_amount' => $total,
                ]);

                return $order->load([
                    'organization',
                    'business',
                    'user',
                    'items.product',
                    'invoice',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Order Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Order $order, array $data): Order
    {
        try {
            return DB::transaction(function () use ($order, $data) {

//  Restore Previous Stock:
                foreach ($order->items as $item) {

                    $item->product->increment(
                        'quantity',
                        $item->quantity
                    );
                }

//  Delete Previous Items:
                $order->items()->delete();
                $subtotal = 0;

//  Validate New Stock:
                foreach ($data['items'] as $item) {

                    $product = Product::where(
                        'code',
                        $item['product_code']
                    )->firstOrFail();

                    if ($product->quantity < $item['quantity']) {

                        throw new \Exception("Insufficient stock for {$product->name}.");
                    }

                    $subtotal += $product->selling_price * $item['quantity'];
                }

                $discount = $data['discount'] ?? 0;
                $tax = $data['tax'] ?? 0;
                $total = ($subtotal - $discount) + $tax;


//  Update Order:
                $order->update([
                    'organization_code' => $data['organization_code'] ?? $order->organization_code,
                    'business_code' => $data['business_code'] ?? $order->business_code,
                    'user_code' => $data['user_code'] ?? $order->user_code,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                    'payment_method' => $data['payment_method'] ?? $order->payment_method,
                    'payment_status' => $data['payment_status'] ?? $order->payment_status,
                    'status' => $data['status'] ?? $order->status,
                ]);

//  Create New Order Items:
                foreach ($data['items'] as $item) {

                    $product = Product::where(
                        'code',
                        $item['product_code']
                    )->first();

                    OrderItem::create([
                        'code' => $this->generateCode('ODI', OrderItem::class),
                        'order_code' => $order->code,
                        'product_code' => $product->code,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->selling_price,
                        'discount' => 0,
                        'subtotal' => $product->selling_price * $item['quantity'],
                    ]);

                    $product->decrement('quantity', $item['quantity']);
                }

//  Update Invoice:
                if ($order->invoice) {

                    $order->invoice->update([
                        'subtotal' => $subtotal,
                        'discount' => $discount,
                        'tax' => $tax,
                        'total_amount' => $total,
                        'payment_status' => $order->payment_status,
                    ]);
                }

                return $order->fresh()->load([

                    'organization',
                    'business',
                    'user',
                    'items.product',
                    'invoice',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Order Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(Order $order): bool
    {
        try {
            return DB::transaction(function () use ($order) {

//  Restore Product Stock:

                foreach ($order->items as $item) {
                    $item->product->increment('quantity', $item->quantity);
                }

                if ($order->invoice) {
                    $order->invoice->delete();
                }

                $order->items()->delete();

                $order->delete();

                return true;

            });

        } catch (\Throwable $e) {
            Log::error('Order Delete Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
