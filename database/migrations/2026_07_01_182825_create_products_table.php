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
        if (!Schema::hasTable('shift_schedules')) {

            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('code', 8)->unique();

                $table->string('organization_code', 8)->nullable();
                $table->string('categories_code', 8)->nullable();
                $table->string('sub_categories_code', 8)->nullable();

                $table->string('product_name');
                $table->string('product_description');
                $table->string('sku');
                $table->string('product_image_path');

                $table->decimal('product_price', 15, 2)->default(0.00);
                $table->integer('quantity')->default(0);

                $table->timestamps();

                $table->foreign('code')
                    ->references('code')
                    ->on('categories')
                    ->onDelete('cascade');

                $table->foreign('sub_categories_code')
                    ->references('code')
                    ->on('subcategories')
                    ->onDelete('cascade');

                $table->foreign('product_code')  // need to change this from name to code with a new migration
                    ->references('name')
                    ->on('products')
                    ->onDelete('cascade');

                $table->index('code');
                $table->index('product_name');
                $table->index('organization_code');
                $table->index('subcategories_code');
                $table->index('categories_code');
                $table->index('sku');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
