<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainers', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();

            $table->string('business_code', 8)->nullable();
            $table->string('staff_code', 8)->unique();

            $table->text('experience')->nullable();
            $table->text('certifications')->nullable();
            $table->text('specialization')->nullable();
            $table->text('bio')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->foreign('staff_code')
                ->references('code')
                ->on('staff')
                ->cascadeOnDelete();

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->cascadeOnDelete();

            $table->index('staff_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer');
    }
};
