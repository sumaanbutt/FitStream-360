<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('organization_code', 8);
            $table->string('created_by', 8);

            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', [
                'strength',
                'cardio',
                'functional',
                'free_weight',
                'machine',
                'accessory',
                'other',
            ])->default('other');

            $table->string('equipment_image_path')->nullable();

            $table->boolean('status')->default(1);
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
            $table->index('category');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
