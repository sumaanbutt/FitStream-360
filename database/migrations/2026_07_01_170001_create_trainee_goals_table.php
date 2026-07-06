<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('trainee_goals', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('trainee_code', 8)->nullable();
            $table->string('user_code', 8)->nullable();

            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('target_value', 8, 2);
            $table->string('target_unit', 20);

            $table->date('start_date');
            $table->date('target_date');

            $table->enum('status', [
                'pending',
                'active',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('trainee_code')
                ->references('code')
                ->on('trainees')
                ->cascadeOnDelete();

            $table->foreign('user_code')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('code');
            $table->index('trainee_code');
            $table->index('user_code');
            $table->index('status');
            $table->index('target_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainee_goals');
    }
};
