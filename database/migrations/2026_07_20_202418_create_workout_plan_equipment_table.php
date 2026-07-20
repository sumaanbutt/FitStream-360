<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_plan_equipment', function (Blueprint $table)
        {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('workout_plan_code', 8);
            $table->string('equipment_code', 8);

            $table->unsignedTinyInteger('quantity')->default(1);
            $table->boolean('is_required')->default(1);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('workout_plan_code')
                ->references('code')
                ->on('workout_plans')
                ->cascadeOnDelete();

            $table->foreign('equipment_code')
                ->references('code')
                ->on('equipments')
                ->cascadeOnDelete();

            $table->unique([
                'workout_plan_code',
                'equipment_code',
            ]);

            $table->index('workout_plan_code');
            $table->index('equipment_code');
            $table->index('is_required');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plan_equipments');
    }
};
