<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plans', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('organization_code', 8);
            $table->string('created_by', 8);

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('goal', [
                'weight_loss',
                'muscle_gain',
                'maintenance',
                'performance',
                'general_health',
                'other',
            ]);

            $table->enum('diet_type', [
                'balanced',
                'high_protein',
                'low_carb',
                'keto',
                'vegetarian',
                'vegan',
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

            $table->unsignedTinyInteger('meals_per_day');

            $table->unsignedInteger('target_calories')->nullable();

            $table->decimal('target_protein',8,2)->nullable();

            $table->decimal('target_carbohydrates',8,2)->nullable();

            $table->decimal('target_fat',8,2)->nullable();

            $table->decimal('price',10,2)->default(0);

            $table->string('currency',3)->default('PKR');

            $table->string('cover_image_path')->nullable();

            $table->enum('status',[
                'draft',
                'active',
                'inactive',
            ])->default('draft');

            $table->timestamps();

            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->cascadeOnDelete();

            $table->foreign('created_by')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('organization_code');
            $table->index('created_by');
            $table->index('goal');
            $table->index('diet_type');
            $table->index('level');
            $table->index('gender');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plans');
    }
};
