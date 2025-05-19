<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('remarks_for_professional')->nullable()->after('remarks');
            $table->string('customer_document')->nullable()->after('remarks_for_professional');
            $table->decimal('paid_amount', 10, 2)->nullable()->after('customer_document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'remarks_for_professional')) {
                $table->dropColumn('remarks_for_professional');
            }

            if (Schema::hasColumn('bookings', 'customer_document')) {
                $table->dropColumn('customer_document');
            }

            if (Schema::hasColumn('bookings', 'paid_amount')) {
                $table->dropColumn('paid_amount');
            }
        });
    }
};
