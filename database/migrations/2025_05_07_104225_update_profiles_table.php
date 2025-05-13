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
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);

            // Add name field
            $table->string('name')->nullable()->after('professional_id');
            if (Schema::hasColumn('profiles', 'profile_photo')) {
                $table->renameColumn('profile_photo', 'photo');
            }

            $table->text('education2')->nullable()->after('education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['name', 'education2']);

            $table->string('first_name')->nullable()->after('professional_id');
            $table->string('last_name')->nullable()->after('first_name');
            if (Schema::hasColumn('profiles', 'photo')) {
                $table->renameColumn('photo', 'profile_photo');
            }
        });
    }
};
