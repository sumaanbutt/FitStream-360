<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('order_code', 8)->nullable();

            $table->string('business_code', 8)->nullable();
            $table->string('user_code', 8)->nullable();

            $table->enum('invoice_type', [
                'POS',
                'order'
            ]);

            $table->enum('payment_status', [
                'paid',
                'unpaid',
                'overdue',
                'cancelled'
            ])->default('unpaid');

            $table->decimal('total_amount', 12, 2)->default(0);

            $table->timestamps();

            $table->foreign('order_code')
                ->references('code')
                ->on('orders')
                ->cascadeOnDelete();

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->cascadeOnDelete();

            $table->foreign('user_code')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('order_code');
            $table->index('business_code');
            $table->index('user_code');
            $table->index('payment_status');
            $table->index('invoice_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
