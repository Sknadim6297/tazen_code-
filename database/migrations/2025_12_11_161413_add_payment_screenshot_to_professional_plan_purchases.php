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
        Schema::table('professional_plan_purchases', function (Blueprint $table) {
            $table->string('payment_screenshot')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_plan_purchases', function (Blueprint $table) {
            $table->dropColumn('payment_screenshot');
        });
    }
};
