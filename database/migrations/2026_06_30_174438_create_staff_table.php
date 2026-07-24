<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {

            $table->id();

            $table->string('code', 8)->unique();

            // Relationships
            $table->string('business_code', 8);
            $table->string('user_code', 8);

            // Staff Type
            $table->enum('staff_type', [
                'operations',
                'trainer',
            ]);

            // Staff Information
            $table->decimal('salary', 10, 2)->default(0);

            $table->string('cnic', 20)->nullable();
            $table->string('blood_group', 10)->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();

            $table->date('joining_date');

            $table->boolean('status')->default(true);

            $table->timestamps();

            // Foreign Keys
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
            $table->index('staff_type');
            $table->index('blood_group');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
