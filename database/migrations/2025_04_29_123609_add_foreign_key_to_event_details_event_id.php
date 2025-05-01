<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_details', function (Blueprint $table) {
            // Add the column if it doesn't exist
            if (!Schema::hasColumn('event_details', 'event_id')) {
                $table->unsignedBigInteger('event_id')->after('id'); // Adjust position as needed
            }

            // Add the foreign key constraint
            $table->foreign('event_id')
                ->references('id')
                ->on('all_events')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('event_details', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id'); // Optional: remove column too
        });
    }
};
