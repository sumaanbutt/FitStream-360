<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->string('code' , 8)->unique();

                $table->string('order_code' , 8)->nullable();
                $table->string('product_code' , 8)->nullable();

                $table->integer('quantity');
                $table->decimal('unit_price', 15, 2)->default(0);
                $table->decimal('discount', 15, 2)->default(0);
                $table->decimal('subtotal', 15, 2)->default(0);

                $table->timestamps();

                $table->foreign('order_code')
                    ->references('code')
                    ->on('orders')
                    ->onDelete('cascade');

                $table->foreign('product_code')
                    ->references('code')
                    ->on('products')
                    ->onDelete('cascade');

                $table->index('code');
                $table->index('order_code');
                $table->index('product_code');
                $table->index('quantity');
                $table->index('discount');

            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
