<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
//        if (!Schema::hasTable('workout_plans')) {
            Schema::create('workout_plans', function (Blueprint $table) {
                $table->id();
                $table->string('code', 8)->unique();

                $table->string('title');
                $table->enum('workout_type', ['']);
                $table->string('duration');
                $table->enum('duration_uom', ['minute', 'hour']);
                $table->string('image_path', 2048)->nullable();
                $table->string('pdf_file_path')->nullable();

                $table->timestamps();
            });
//        }
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
