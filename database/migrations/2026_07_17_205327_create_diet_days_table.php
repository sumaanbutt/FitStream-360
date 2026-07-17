<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plan_days', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('diet_plan_code', 8);
            $table->string('diet_plan_week_code', 8);

            $table->unsignedTinyInteger('day_number');

            $table->enum('day_name', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ]);

            $table->string('title');

            $table->text('description')->nullable();

            $table->unsignedInteger('target_calories')->nullable();

            $table->decimal('target_protein', 8, 2)->nullable();

            $table->decimal('target_carbohydrates', 8, 2)->nullable();

            $table->decimal('target_fat', 8, 2)->nullable();

            $table->decimal('water_target_liters', 5, 2)->nullable();

            $table->text('notes')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->foreign('diet_plan_code')
                ->references('code')
                ->on('diet_plans')
                ->cascadeOnDelete();

            $table->foreign('diet_plan_week_code')
                ->references('code')
                ->on('diet_plan_weeks')
                ->cascadeOnDelete();

            $table->unique([
                'diet_plan_week_code',
                'day_number',
            ]);

            $table->index('diet_plan_code');
            $table->index('diet_plan_week_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plan_days');
    }
};
