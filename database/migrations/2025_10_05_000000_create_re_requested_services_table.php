<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_requested_services', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relations
            $table->unsignedBigInteger('professional_id')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('original_booking_id')->nullable()->index();

            // Service / pricing
            $table->string('service_name')->nullable();
            $table->text('reason')->nullable();
            $table->decimal('original_price', 12, 2)->default(0);
            $table->decimal('admin_modified_price', 12, 2)->nullable()->default(0);
            $table->decimal('final_price', 12, 2)->nullable()->default(0);

            // GST fields
            $table->decimal('gst_amount', 12, 2)->nullable()->default(0);
            $table->decimal('cgst_amount', 12, 2)->nullable()->default(0);
            $table->decimal('sgst_amount', 12, 2)->nullable()->default(0);
            $table->decimal('cgst_rate', 5, 2)->nullable()->default(8.00);
            $table->decimal('sgst_rate', 5, 2)->nullable()->default(8.00);
            $table->decimal('total_amount', 12, 2)->nullable()->default(0);

            // Statuses
            $table->enum('status', ['pending','admin_approved','customer_paid','rejected','cancelled'])->default('pending');
            $table->enum('priority', ['low','normal','high','urgent'])->default('normal');
            $table->enum('payment_status', ['unpaid','paid','failed','refunded'])->default('unpaid');

            // Payment & timestamps
            $table->string('payment_id')->nullable()->index();
            $table->string('payment_link')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('admin_approved_at')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            $table->timestamp('customer_viewed_at')->nullable();
            $table->timestamp('professional_notified_at')->nullable();

            // Notes
            $table->text('admin_notes')->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            // Foreign keys (nullable to avoid strict FK errors on seed / import)
            $table->foreign('professional_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('original_booking_id')->references('id')->on('bookings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_requested_services');
    }
};
