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
            $table->string('transaction_number')->nullable()->after('amount');
            $table->date('paid_date')->nullable()->after('transaction_number');
            $table->enum('paid_status', ['paid', 'unpaid'])->default('unpaid')->after('paid_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'transaction_number')) {
                $table->dropColumn('transaction_number');
            }
            if (Schema::hasColumn('bookings', 'paid_date')) {
                $table->dropColumn('paid_date');
            }
            if (Schema::hasColumn('bookings', 'paid_status')) {
                $table->dropColumn('paid_status');
            }
        });
    }
};
