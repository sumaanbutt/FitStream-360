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
        Schema::table('businesses', function (Blueprint $table) {

            $table->dropColumn([
                'discount_percentage',
                'agreement_start',
                'agreement_end',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {

            $table->decimal('discount_percentage', 5, 2)
                ->default(0.00)
                ->after('phone');

            $table->date('agreement_start')
                ->after('status');

            $table->date('agreement_end')
                ->after('agreement_start');

        });
    }
};
