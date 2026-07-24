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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();

            $table->string('organization_code', 8);

            $table->foreign('organization_code')
                ->references('code')
                ->on('organizations')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20);

            $table->boolean('status')->default(true);
            $table->timestamps();


            $table->index('name');
            $table->index('status');
            $table->index('organization_code');
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
