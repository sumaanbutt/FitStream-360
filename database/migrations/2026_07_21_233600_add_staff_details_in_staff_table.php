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
        Schema::table('staff', function (Blueprint $table) {

            // If you already created staff_type manually in phpMyAdmin,
            // uncomment the next line before running the migration.
            // $table->dropColumn('staff_type');

            // New columns
//            $table->enum('staff_type', [
//                'operations',
//                'trainer',
//            ])->after('user_code');

            $table->string('cnic', 20)
                ->nullable()
                ->after('salary');

            $table->string('blood_group', 10)
                ->nullable()
                ->after('cnic');

            $table->string('emergency_contact_name')
                ->nullable()
                ->after('blood_group');

            $table->string('emergency_contact_phone', 20)
                ->nullable()
                ->after('emergency_contact_name');

            $table->index('staff_type');
            $table->index('blood_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {

            $table->dropIndex(['staff_type']);
            $table->dropIndex(['blood_group']);

            $table->dropColumn([
                'staff_type',
                'cnic',
                'blood_group',
                'emergency_contact_name',
                'emergency_contact_phone',
            ]);
        });
    }
};
