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
            $table->string('code', 8)->unique();

            $table->string('organization_code', 8)->nullable();
            $table->string('business_code', 8)->nullable();
            $table->string('user_code', 8);

            $table->enum('trainee_type', [
                'organization',
                'business',
            ])->default('business');

            $table->enum('gender', [
                'male',
                'female',
                'other',
            ])->nullable();

            $table->unsignedInteger('age')->nullable();

            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            $table->text('address')->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();

            $table->string('blood_group', 10)->nullable();
            $table->text('allergies')->nullable();
            $table->text('medical_conditions')->nullable();

            $table->json('allowed_locations')->nullable();

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
        $table->dropColumn('trainee_type');
        $table->dropColumn('address');
        $table->dropColumn('emergency_contact_name');
        $table->dropColumn('emergency_contact_phone');
        $table->dropColumn('blood_group');
        $table->dropColumn('allergies');
        $table->dropColumn('medical_conditions');
        $table->dropColumn('allowed_locations');
    }
};
