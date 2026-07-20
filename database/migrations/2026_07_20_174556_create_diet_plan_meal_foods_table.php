<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plan_meal_foods', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();
            $table->string('diet_plan_meal_code', 8);
            $table->string('food_code', 8);

            $table->decimal('quantity', 8, 2)->default(1);
            $table->string('unit', 30)->default('g');

            $table->unsignedInteger('calories')->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('carbohydrates', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('diet_plan_meal_code')
                ->references('code')
                ->on('diet_plan_meals')
                ->cascadeOnDelete();

            $table->foreign('food_code')
                ->references('code')
                ->on('foods')
                ->cascadeOnDelete();

            $table->index('diet_plan_meal_code');
            $table->index('food_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plan_meal_foods');
    }
};
