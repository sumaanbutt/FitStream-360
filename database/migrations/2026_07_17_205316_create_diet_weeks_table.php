<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plan_weeks', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('diet_plan_code', 8);

            $table->unsignedTinyInteger('week_number');

            $table->string('title')->nullable();

            $table->text('description')->nullable();

            $table->unsignedInteger('target_calories')->nullable();

            $table->decimal('target_protein', 8, 2)->nullable();

            $table->decimal('target_carbohydrates', 8, 2)->nullable();

            $table->decimal('target_fat', 8, 2)->nullable();

            $table->text('instructions')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->foreign('diet_plan_code')
                ->references('code')
                ->on('diet_plans')
                ->cascadeOnDelete();

            $table->unique([
                'diet_plan_code',
                'week_number',
            ]);

            $table->index('diet_plan_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plan_weeks');
    }
};
