<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_categories', function (Blueprint $table) {

            $table->id();
            $table->string('code', 8)->unique();
            $table->string('business_code', 8);
            $table->string('created_by', 8);
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('status')->default('1');

            $table->timestamps();

            $table->foreign('business_code')
                ->references('code')
                ->on('businesses')
                ->cascadeOnDelete();

            $table->foreign('created_by')
                ->references('code')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('business_code');
            $table->index('created_by');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_categories');
    }
};
