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
        Schema::create('trainee_goals_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('trainee_goal_code', 8)->nullable();
            $table->string('uploaded_by', 8);

            $table->enum('attachment_type', [
                'image',
                'video',
                'pdf',
                'document',
            ]);

            $table->string('file_name');
            $table->string('file_path');
            $table->text('description')->nullable();

            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();

            $table->foreign('trainee_goal_code')
                ->references('code')
                ->on('trainee_goals')
                ->cascadeOnDelete();

            $table->foreign('uploaded_by')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('code');
            $table->index('trainee_goal_code');
            $table->index('uploaded_by');
            $table->index('attachment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_goals_attachments');
    }
};
