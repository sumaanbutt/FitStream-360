<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('organization_code', 8)->nullable();
            $table->string('user_code', 8)->nullable();

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            $table->enum('payment_status', [
                'paid',
                'unpaid'
            ])->default('unpaid');

            $table->enum('status', [
                'pending',
                'processing',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->enum('payment_method', [
                'cash',
                'card',
                'bank'
            ]);

            $table->timestamps();

            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->cascadeOnDelete();

            $table->foreign('user_code')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('status');
            $table->index('organization_code');
            $table->index('user_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
