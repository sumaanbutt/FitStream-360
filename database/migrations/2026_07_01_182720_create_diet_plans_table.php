<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->string('code' ,8)->unique();

//            $table->string('organization_code', 8); not in this migration yet
//            $table->string('created_by', 8); not in this migration yet

            $table->string('title');
//            $table->string('description')->nullable(); not in this migration yet

            $table->enum('diet_type' , [
//                    'weight_loss',  these 4 are also not in this migration
//                    'weight_gain',
//                    'maintenance',
//                    'muscle_gain',
                ]);

            $table->string('duration');
            $table->enum('duration_uom' , ['day' , 'week' , 'month' , 'year']);

            $table->string('calories');

            $table->string('image_path')->nullable();
            $table->string('pdf_file_path')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

//            $table->foreign('organization_code') Not in migration yet
//                ->references('code')
//                ->on('organizations')
//                ->cascadeOnDelete();
//
//            $table->foreign('created_by')
//                ->references('code')
//                ->on('users')
//                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plan');
    }
};
