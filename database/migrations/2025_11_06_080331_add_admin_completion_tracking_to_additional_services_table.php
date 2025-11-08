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
        Schema::table('additional_services', function (Blueprint $table) {
            $table->timestamp('admin_completed_at')->nullable()->after('customer_confirmed_at');
            $table->text('admin_completion_note')->nullable()->after('admin_completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_services', function (Blueprint $table) {
            $table->dropColumn(['admin_completed_at', 'admin_completion_note']);
        });
    }
};
