<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('availability_slots', function (Blueprint $table) {
            if (Schema::hasColumn('availability_slots', 'start_period')) {
                $table->dropColumn('start_period');
            }
            if (Schema::hasColumn('availability_slots', 'end_period')) {
                $table->dropColumn('end_period');
            }
        });
    }

    public function down(): void
    {
        Schema::table('availability_slots', function (Blueprint $table) {
            if (!Schema::hasColumn('availability_slots', 'start_period')) {
                $table->string('start_period', 2)->nullable()->after('start_time');
            }
            if (!Schema::hasColumn('availability_slots', 'end_period')) {
                $table->string('end_period', 2)->nullable()->after('end_time');
            }
        });
    }
};
