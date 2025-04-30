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
        Schema::table('event_details', function (Blueprint $table) {
            $table->foreign('event_id')
                ->references('id')
                ->on('all_events')
                ->onDelete('cascade'); // optional: delete related event_details if all_events entry is deleted
        });
    }

    public function down(): void
    {
        Schema::table('event_details', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
        });
    }
};
