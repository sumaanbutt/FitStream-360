<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up():void
    {
        Schema::create('trainee_goal_progress',function(Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();
            $table->string('trainee_goal_code', 8);

            $table->decimal('weight',5,2)->nullable();
            $table->decimal('body_fat',5,2)->nullable();
            $table->decimal('muscle_mass',5,2)->nullable();
            $table->decimal('chest',5,2)->nullable();
            $table->decimal('waist',5,2)->nullable();
            $table->decimal('hips',5,2)->nullable();
            $table->decimal('arms',5,2)->nullable();
            $table->decimal('thighs',5,2)->nullable();

            $table->decimal('progress_percentage',5,2)->nullable();

            $table->text('notes')->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->foreign('trainee_goal_code')
                ->references('code')
                ->on('trainee_goals')
                ->cascadeOnDelete();

            $table->index('trainee_goal_code');
            $table->index('recorded_at');
        });
    }

    public function down():void
    {
        Schema::dropIfExists('trainee_goal_progress');
    }
};


//uom according to system
//the progress number can be multiple in future as we may need to keep history like progress of trainee now, after 1 week etc
