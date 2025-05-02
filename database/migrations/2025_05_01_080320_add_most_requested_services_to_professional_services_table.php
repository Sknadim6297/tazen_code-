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
        Schema::table('professional_services', function (Blueprint $table) {
            $table->json('most_requested_services')->nullable()->after('requirements');
            $table->json('most_requested_services_upto_price')->nullable()->after('most_requested_services');
        });
    }

    public function down(): void
    {
        Schema::table('professional_services', function (Blueprint $table) {
            $table->dropColumn('most_requested_services');
            $table->dropColumn('most_requested_services_upto_price');
        });
    }
};
