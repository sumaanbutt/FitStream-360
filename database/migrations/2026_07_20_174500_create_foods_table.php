<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();
            $table->string('organization_code', 8);
            $table->string('created_by', 8);
            $table->string('food_category_code', 8)->nullable();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('brand')->nullable();
            $table->string('serving_unit')->default('g');

            $table->decimal('serving_size', 8, 2)->default(100);
            $table->unsignedInteger('calories')->default(0);
            $table->decimal('protein', 8, 2)->default(0);
            $table->decimal('carbohydrates', 8, 2)->default(0);
            $table->decimal('fat', 8, 2)->default(0);
            $table->decimal('fiber', 8, 2)->nullable();
            $table->string('image_path')->nullable();

            $table->boolean('status')->default('1');

            $table->timestamps();

            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->cascadeOnDelete();

            $table->foreign('created_by')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('food_category_code')
                ->references('code')
                ->on('food_categories')
                ->nullOnDelete();

            $table->index('organization_code');
            $table->index('created_by');
            $table->index('food_category_code');
            $table->index('name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
