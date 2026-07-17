<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_weeks', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('workout_plan_code', 8);

            $table->unsignedTinyInteger('week_number');

            $table->string('title')->nullable();

            $table->text('description')->nullable();

            $table->text('instructions')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->foreign('workout_plan_code')
                ->references('code')
                ->on('workout_plans')
                ->cascadeOnDelete();

            $table->unique([
                'workout_plan_code',
                'week_number'
            ]);

            $table->index('workout_plan_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_weeks');
    }
};
