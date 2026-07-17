<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {

            $table->id();
            $table->string('session_code', 64)->unique();

            $table->string('user_code', 8);
            $table->string('ip_address')->nullable();

            $table->text('user_agent')->nullable();

            $table->timestamp('last_activity');
            $table->timestamp('expires_at');

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('user_code')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('session_code');
            $table->index('user_code');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
