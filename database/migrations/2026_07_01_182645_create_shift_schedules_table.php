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
//        if (!Schema::hasTable('shift_schedules')) {
            Schema::create('shift_schedules', function (Blueprint $table) {
                $table->id();
                $table->string('code', 8)->unique();

                $table->string('business_code', 8)->nullable();
                $table->string('staff_code', 8)->nullable();

                $table->enum('working_days', [
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday'
                ]);

                $table->time('start_time');
                $table->time('end_time');

                $table->enum('status', ['active', 'inactive'])->default('active');

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
                $table->index('business_code');
                $table->index('staff_code');
                $table->index('working_days');
                $table->index('status');
            });
//        }
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_schedules');
    }
};
