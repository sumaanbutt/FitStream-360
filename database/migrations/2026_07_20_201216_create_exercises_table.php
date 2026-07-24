<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('business_code', 8);
            $table->string('created_by', 8);

            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('exercise_type', [
                'strength',
                'cardio',
                'stretching',
                'mobility',
                'plyometric',
                'rehabilitation',
            ])->default('strength');

            $table->enum('primary_muscle', [
                'chest',
                'back',
                'shoulders',
                'biceps',
                'triceps',
                'legs',
                'glutes',
                'abs',
                'forearms',
                'calves',
                'full_body',
            ]);

            $table->json('secondary_muscles')->nullable();
            $table->enum('difficulty', [
                'beginner',
                'intermediate',
                'advanced',
            ])->default('beginner');

            $table->text('instructions')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image_path')->nullable();

            $table->boolean('status')->default(1);
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
            $table->index('exercise_type');
            $table->index('primary_muscle');
            $table->index('difficulty');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
