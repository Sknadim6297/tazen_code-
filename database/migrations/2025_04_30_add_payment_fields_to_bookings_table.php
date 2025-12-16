<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('bookings', 'payment_id')) {
                $table->string('payment_id')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            }
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'amount')) {
                $table->dropColumn('amount');
            }
            if (Schema::hasColumn('bookings', 'payment_id')) {
                $table->dropColumn('payment_id');
            }
            if (Schema::hasColumn('bookings', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
        });
    }
}; 