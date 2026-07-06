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
//        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->string('code', 8)->unique();

                $table->string('organization_code', 8)->nullable();
                $table->string('user_code', 8)->nullable();
                $table->string('order_code', 8)->nullable(); //not added yet

                $table->enum('invoice_type', ['POS', 'order']);
                $table->enum('payment_status', ['paid', 'unpaid', 'overdue', 'cancelled'])->default('unpaid'); //failed, refunded
//                $table->enum('payment_method', ['cash', 'bank_transfer',]);

//                $table->decimal('subtotal', 12, 2);
//                $table->decimal('discount', 12, 2)->default(0);
//                $table->decimal('tax', 12, 2)->default(0);
                $table->decimal('total_amount', 12, 2)->default(0);

//                $table->enum('status', ['draft', 'issued', 'cancelled',])->default('issued');

                $table->timestamps();

                $table->foreign('user_code')
                    ->references('code')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('organization_code')
                    ->references('code')
                    ->on('organizations')
                    ->onDelete('cascade');

                $table->foreign('order_code')
                    ->references('code')
                    ->on('orders')
                    ->onDelete('cascade');

                $table->index('code');
                $table->index('organization_code');
                $table->index('user_code');
                $table->index('order_code');
                $table->index('payment_status');
                $table->index('invoice_type');

            });
//        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
