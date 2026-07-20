<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_day_exercises', function (Blueprint $table)
        {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('workout_plan_code', 8);
            $table->string('workout_week_code', 8);
            $table->string('workout_day_code', 8);
            $table->string('exercise_code', 8);

            $table->unsignedTinyInteger('sets')->nullable();
            $table->string('reps', 30)->nullable();

            $table->decimal('weight', 8, 2)->nullable();
            $table->string('weight_unit', 10)->nullable();

            $table->unsignedSmallInteger('duration_seconds')->nullable();
            $table->unsignedSmallInteger('rest_seconds')->nullable();

            $table->decimal('distance', 8, 2)->nullable();
            $table->string('distance_unit', 10)->nullable();

            $table->decimal('target_percentage', 5, 2)->nullable();
            $table->decimal('target_rpe', 4, 1)->nullable();

            $table->boolean('is_optional')->default(0);
            $table->text('instructions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('workout_plan_code')
                ->references('code')
                ->on('workout_plans')
                ->cascadeOnDelete();

            $table->foreign('workout_week_code')
                ->references('code')
                ->on('workout_weeks')
                ->cascadeOnDelete();

            $table->foreign('workout_day_code')
                ->references('code')
                ->on('workout_days')
                ->cascadeOnDelete();

            $table->foreign('exercise_code')
                ->references('code')
                ->on('exercises')
                ->cascadeOnDelete();

            $table->index('workout_plan_code');
            $table->index('workout_week_code');
            $table->index('workout_day_code');
            $table->index('exercise_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_day_exercises');
    }
};
