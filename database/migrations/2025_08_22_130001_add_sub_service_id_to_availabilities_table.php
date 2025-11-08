<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('availabilities', 'sub_service_id')) {
                $table->unsignedBigInteger('sub_service_id')->nullable()->after('professional_service_id');
                $table->foreign('sub_service_id', 'availabilities_sub_service_id_fk')
                      ->references('id')->on('sub_services')->onDelete('set null');
                $table->index('sub_service_id', 'availabilities_sub_service_id_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (Schema::hasColumn('availabilities', 'sub_service_id')) {
                $table->dropForeign('availabilities_sub_service_id_fk');
                $table->dropIndex('availabilities_sub_service_id_idx');
                $table->dropColumn('sub_service_id');
            }
        });
    }
};
