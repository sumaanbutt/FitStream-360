<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code' ,8)->unique();

            $table->string('business_code', 8)->nullable();
            $table->string('staff_code', 8)->nullable();

            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postal_code')->nullable();

            $table->enum('location_type', ['staff','business']);
            $table->enum('location_status', ['active','inactive'])->default('active');

            $table->timestamps();

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->cascadeOnDelete();

            $table->foreign('staff_code')
                ->references('code')
                ->on('staff')
                ->cascadeOnDelete();

            $table->index('code');
            $table->index('staff_code');
            $table->index('location_type');
            $table->index('location_status');
            $table->index('city');
            $table->index('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
