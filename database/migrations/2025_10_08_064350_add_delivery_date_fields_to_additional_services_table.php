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
            $table->timestamp('delivery_date_set_by_professional_at')->nullable()->after('delivery_date');
            $table->timestamp('delivery_date_modified_by_admin_at')->nullable()->after('delivery_date_set_by_professional_at');
            $table->text('delivery_date_reason')->nullable()->after('delivery_date_modified_by_admin_at');
            $table->boolean('can_complete_consultation')->default(false)->after('delivery_date_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_services', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_date_set_by_professional_at',
                'delivery_date_modified_by_admin_at', 
                'delivery_date_reason',
                'can_complete_consultation'
            ]);
        });
    }
};
