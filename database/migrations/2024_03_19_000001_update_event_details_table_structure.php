<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_details', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('event_details', 'meeting_link')) {
                $table->dropColumn('meeting_link');
            }
            if (Schema::hasColumn('event_details', 'landmark')) {
                $table->dropColumn('landmark');
            }

            // Modify existing columns
            $table->string('banner_image', 255)->change();
            $table->string('event_type', 255)->change();
            $table->text('event_details')->change();
            $table->date('starting_date')->change();
            $table->decimal('starting_fees', 10, 2)->change();
            $table->longText('event_gallery')->nullable()->change();
            $table->string('city', 255)->nullable()->change();
            $table->enum('event_mode', ['online', 'offline'])->nullable()->change();

            // Add foreign key constraint if not exists
            if (!Schema::hasColumn('event_details', 'event_id')) {
                $table->foreignId('event_id')->constrained('all_events')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('event_details', function (Blueprint $table) {
            // Add back the dropped columns
            $table->string('meeting_link', 255)->nullable();
            $table->string('landmark', 255)->nullable();

            // Revert column modifications
            $table->string('banner_image', 255)->change();
            $table->string('event_type', 255)->change();
            $table->text('event_details')->change();
            $table->date('starting_date')->change();
            $table->decimal('starting_fees', 10, 2)->change();
            $table->longText('event_gallery')->nullable()->change();
            $table->string('city', 255)->nullable()->change();
            $table->enum('event_mode', ['online', 'offline'])->nullable()->change();
        });
    }
}; 