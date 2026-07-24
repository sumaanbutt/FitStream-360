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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('business_code', 8)->nullable();
            $table->string('category_code', 8)->nullable();
            $table->string('subcategory_code', 8)->nullable();

            $table->string('product_name');
            $table->string('product_description');
            $table->string('sku');
            $table->string('product_image_path');

            $table->decimal('product_price', 15, 2)->default(0.00);
            $table->integer('quantity')->default(0);

            $table->timestamps();

            $table->foreign('category_code')
                ->references('code')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('subcategory_code')
                ->references('code')
                ->on('sub_categories')
                ->onDelete('cascade');

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->onDelete('cascade');

            $table->index('code');
            $table->index('product_name');
            $table->index('business_code');
            $table->index('subcategory_code');
            $table->index('category_code');
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
