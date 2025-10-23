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
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('bookings', 'payment_screenshot')) {
                $table->string('payment_screenshot')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('bookings', 'payment_notes')) {
                $table->text('payment_notes')->nullable()->after('payment_screenshot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'payment_method', 'payment_screenshot', 'payment_notes']);
        });
    }
};
