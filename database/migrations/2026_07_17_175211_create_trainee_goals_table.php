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

            $table->string('organization_code', 8);
            $table->string('trainee_code', 8)->nullable();
            $table->string('created_by', 8);

            $table->string('title', 100);
            $table->text('description')->nullable();

            $table->tinyInteger('priority')->default(1);

            $table->decimal('target_weight', 5, 2)->nullable();
            $table->decimal('target_body_fat', 5, 2)->nullable();

            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();

            $table->enum('goal_source', [
                'gym',
                'trainee',
            ]);

            $table->enum('category', [
                'body_composition',
                'performance',
                'health',
                'lifestyle',
                'sport',
                'rehabilitation',
                'other',
            ])->default('other');

            $table->enum('status', [
                'active',
                'completed',
                'cancelled',
            ])->default('active');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->cascadeOnDelete();

            $table->foreign('trainee_code')
                ->references('code')
                ->on('trainees')
                ->nullOnDelete();

            $table->foreign('created_by')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();


            $table->index('code');
            $table->index('organization_code');
            $table->index('trainee_code');
            $table->index('created_by');
            $table->index('goal_source');
            $table->index('category');
            $table->index('status');
            $table->index('target_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainee_goals');
    }
};
