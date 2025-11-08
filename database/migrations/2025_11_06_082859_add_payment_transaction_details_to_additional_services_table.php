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
            $table->string('payment_transaction_id')->nullable()->after('payment_id');
            $table->enum('payment_method', ['bank_transfer', 'upi', 'cheque', 'cash', 'other'])->nullable()->after('payment_transaction_id');
            $table->text('payment_notes')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_services', function (Blueprint $table) {
            $table->dropColumn(['payment_transaction_id', 'payment_method', 'payment_notes']);
        });
    }
};
