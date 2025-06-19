<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('comments', 'website')) {
            // Get the column type
            $columnType = DB::select("SHOW COLUMNS FROM comments WHERE Field = 'website'")[0]->Type;
            // Use raw SQL to rename the column
            DB::statement("ALTER TABLE comments CHANGE website mobile $columnType NULL");
        } else if (!Schema::hasColumn('comments', 'mobile')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->string('mobile')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('comments', 'mobile')) {
            $columnType = DB::select("SHOW COLUMNS FROM comments WHERE Field = 'mobile'")[0]->Type;
            DB::statement("ALTER TABLE comments CHANGE mobile website $columnType NULL");
        }
    }
}; 