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
            // Track reschedule attempts
            if (!Schema::hasColumn('bookings', 'reschedule_count')) {
                $table->integer('reschedule_count')->default(0)->after('status');
            }
            
            // Store original booking details for history
            if (!Schema::hasColumn('bookings', 'original_date')) {
                $table->date('original_date')->nullable()->after('reschedule_count');
            }
            
            if (!Schema::hasColumn('bookings', 'original_time_slot')) {
                $table->string('original_time_slot')->nullable()->after('original_date');
            }
            
            // Reschedule request details
            if (!Schema::hasColumn('bookings', 'reschedule_reason')) {
                $table->text('reschedule_reason')->nullable()->after('original_time_slot');
            }
            
            if (!Schema::hasColumn('bookings', 'reschedule_requested_at')) {
                $table->timestamp('reschedule_requested_at')->nullable()->after('reschedule_reason');
            }
            
            if (!Schema::hasColumn('bookings', 'reschedule_approved_at')) {
                $table->timestamp('reschedule_approved_at')->nullable()->after('reschedule_requested_at');
            }
            
            // Maximum reschedules allowed (configurable per booking)
            if (!Schema::hasColumn('bookings', 'max_reschedules_allowed')) {
                $table->integer('max_reschedules_allowed')->default(2)->after('reschedule_approved_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columnsToRemove = [
                'reschedule_count',
                'original_date', 
                'original_time_slot',
                'reschedule_reason',
                'reschedule_requested_at',
                'reschedule_approved_at',
                'max_reschedules_allowed'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};