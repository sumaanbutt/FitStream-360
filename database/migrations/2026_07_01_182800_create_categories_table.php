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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('organization_code', 8)->nullable();

            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->onDelete('cascade');

            $table->index('code');
            $table->index('name');
            $table->index('organization_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
