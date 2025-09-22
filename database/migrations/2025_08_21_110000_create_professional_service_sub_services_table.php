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
        // Disabled: use `2025_08_21_105502_create_prof_service_sub_services_table.php`
        // which creates the `prof_service_sub_services` pivot table that the
        // application models expect. Keeping this file as a backup but making
        // it a no-op prevents duplicate/incorrect table creation.
        return;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no-op
    }
};
