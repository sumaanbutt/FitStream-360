<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_days', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('workout_plan_code', 8);

            $table->string('workout_week_code', 8);

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

            $table->text('instructions')->nullable();

            $table->unsignedSmallInteger('estimated_duration')->nullable();

            $table->boolean('is_rest_day')->default(false);

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->foreign('workout_plan_code')
                ->references('code')
                ->on('workout_plans')
                ->cascadeOnDelete();

            $table->foreign('workout_week_code')
                ->references('code')
                ->on('workout_weeks')
                ->cascadeOnDelete();

            $table->unique([
                'workout_week_code',
                'day_number'
            ]);

            $table->index('workout_plan_code');
            $table->index('workout_week_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_days');
    }
};
