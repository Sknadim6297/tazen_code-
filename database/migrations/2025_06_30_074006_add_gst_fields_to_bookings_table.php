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
            $table->decimal('base_amount', 10, 2)->nullable()->after('amount')->comment('Base amount before GST');
            $table->decimal('cgst_amount', 10, 2)->default(0)->after('base_amount')->comment('CGST amount (9%)');
            $table->decimal('sgst_amount', 10, 2)->default(0)->after('cgst_amount')->comment('SGST amount (9%)');
            $table->decimal('igst_amount', 10, 2)->default(0)->after('sgst_amount')->comment('IGST amount (0%)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['base_amount', 'cgst_amount', 'sgst_amount', 'igst_amount']);
        });
    }
};
