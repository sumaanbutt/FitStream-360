<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_plans', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('business_code', 8);
            $table->string('created_by', 8);

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('goal', [
                'weight_loss',
                'muscle_gain',
                'strength',
                'endurance',
                'general_fitness',
                'rehabilitation',
                'other',
            ]);

            $table->enum('level', [
                'beginner',
                'intermediate',
                'advanced',
            ])->default('beginner');

            $table->enum('gender', [
                'male',
                'female',
                'unisex',
            ])->default('unisex');

            $table->unsignedTinyInteger('duration_weeks');
            $table->unsignedTinyInteger('days_per_week');
            $table->unsignedSmallInteger('estimated_minutes_per_day')->nullable();

            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('PKR');

            $table->boolean('requires_gym')->default(false);
            $table->string('cover_image_path')->nullable();

            $table->enum('status', [
                'draft',
                'active',
                'inactive',
            ])->default('draft');

            $table->timestamps();

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->cascadeOnDelete();

            $table->foreign('created_by')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('business_code');
            $table->index('created_by');
            $table->index('goal');
            $table->index('level');
            $table->index('gender');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
