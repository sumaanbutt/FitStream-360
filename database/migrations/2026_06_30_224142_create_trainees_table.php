<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainees', function (Blueprint $table) {

            $table->id();

            // Public Code
            $table->string('code', 8)->unique();

            // Relationships
            $table->string('organization_code', 8)->nullable();
            $table->string('business_code', 8)->nullable();
            $table->string('user_code', 8);

            // Personal Information
            $table->enum('gender', [
                'male',
                'female',
                'other',
            ])->nullable();

            $table->unsignedInteger('age')->nullable();

            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            $table->date('joining_date');

            $table->boolean('status')->default(true);
            $table->timestamps();

// Foreign Keys
            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->cascadeOnDelete();

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->cascadeOnDelete();

            $table->foreign('user_code')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

// Indexes

            $table->index('code');
            $table->index('business_code');
            $table->index('user_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
