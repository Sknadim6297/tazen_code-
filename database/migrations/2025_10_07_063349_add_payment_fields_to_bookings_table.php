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
            // Add columns only if they don't exist
            if (!Schema::hasColumn('bookings', 'booking_time')) {
                $table->string('booking_time')->nullable()->after('booking_date');
            }
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->string('status')->default('pending')->after('payment_status');
            }
            if (!Schema::hasColumn('bookings', 'created_by')) {
                $table->string('created_by')->default('customer')->after('status');
            }
            if (!Schema::hasColumn('bookings', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('bookings', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable()->after('razorpay_payment_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_time',
                'status', 
                'created_by',
                'razorpay_payment_id',
                'razorpay_order_id'
            ]);
        });
    }
};
