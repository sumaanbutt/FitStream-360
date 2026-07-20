<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plan_meals', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();
            $table->string('diet_plan_code', 8);
            $table->string('diet_plan_week_code', 8);
            $table->string('diet_plan_day_code', 8);

            $table->enum('meal_type', [
                'breakfast',
                'morning_snack',
                'lunch',
                'evening_snack',
                'dinner',
                'pre_workout',
                'post_workout',
            ]);

            $table->string('title');
            $table->text('description')->nullable();
            $table->time('recommended_time')->nullable();

            $table->unsignedInteger('estimated_calories')->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('carbohydrates', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();
            $table->unsignedTinyInteger('servings')->default(1);

            $table->text('instructions')->nullable();

            $table->boolean('status')->default('1');

            $table->timestamps();

            $table->foreign('diet_plan_code')
                ->references('code')
                ->on('diet_plans')
                ->cascadeOnDelete();

            $table->foreign('diet_plan_week_code')
                ->references('code')
                ->on('diet_plan_weeks')
                ->cascadeOnDelete();

            $table->foreign('diet_plan_day_code')
                ->references('code')
                ->on('diet_plan_days')
                ->cascadeOnDelete();

            $table->index('diet_plan_code');
            $table->index('diet_plan_week_code');
            $table->index('diet_plan_day_code');
            $table->index('meal_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plan_meals');
    }
};
