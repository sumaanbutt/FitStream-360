<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//        if (!Schema::hasTable('orders')) {

            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('code', 8)->unique();

                $table->string('organization_code', 8)->nullable();
                $table->string('business_code', 8)->nullable(); //not added yet
                $table->string('user_code', 8)->nullable();
                $table->string('invoice_code', 8)->nullable();

                $table->decimal('subtotal', 15, 2)->default(0);
                $table->decimal('discount', 15, 2)->default(0);
                $table->decimal('tax', 15, 2)->default(0);
                $table->decimal('total', 15, 2)->default(0);

                $table->enum('payment_status', ['paid','unpaid'])->default('unpaid');//failed, refunded
                $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
                $table->enum('payment_method', ['cash','card','bank']);// bank(bank_transfer), online

                $table->timestamps();

                $table->foreign('organization_code')
                    ->references('code')
                    ->on('organizations')
                    ->onDelete('cascade');

                $table->foreign('user_code')
                    ->references('code')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('invoice_code')
                    ->references('code')
                    ->on('invoices')
                    ->onDelete('cascade');

                $table->index('code');
                $table->index('status');
                $table->index('organization_code');
                $table->index('user_code');
                $table->index('invoice_code');
            });
        }
//    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
