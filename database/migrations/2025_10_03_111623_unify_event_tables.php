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
        Schema::table('all_events', function (Blueprint $table) {
            // Add professional_id for professional events (nullable for admin events)
            $table->unsignedBigInteger('professional_id')->nullable()->after('id');
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            
            // Add approval system fields
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('starting_fees');
            $table->text('admin_notes')->nullable()->after('status');
            $table->unsignedBigInteger('approved_by')->nullable()->after('admin_notes');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Add foreign key for approved_by
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');
            
            // Add created_by_type to distinguish admin vs professional events
            $table->enum('created_by_type', ['admin', 'professional'])->default('admin')->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_events', function (Blueprint $table) {
            $table->dropForeign(['professional_id']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'professional_id',
                'status',
                'admin_notes',
                'approved_by',
                'approved_at',
                'created_by_type'
            ]);
        });
    }
};
