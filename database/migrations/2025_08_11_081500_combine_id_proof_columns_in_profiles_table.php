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
        Schema::table('profiles', function (Blueprint $table) {
            // Add the new combined ID proof document column
            $table->string('id_proof_document')->nullable()->after('qualification_document');
        });
        
        // Migrate existing data from aadhaar_card and pan_card to id_proof_document
        DB::table('profiles')->whereNotNull('aadhaar_card')->update([
            'id_proof_document' => DB::raw('aadhaar_card')
        ]);
        
        DB::table('profiles')->whereNotNull('pan_card')->update([
            'id_proof_document' => DB::raw('pan_card')
        ]);
        
        Schema::table('profiles', function (Blueprint $table) {
            // Drop the old separate columns
            $table->dropColumn(['aadhaar_card', 'pan_card']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Re-add the old columns
            $table->string('aadhaar_card')->nullable()->after('qualification_document');
            $table->string('pan_card')->nullable()->after('aadhaar_card');
        });
        
        // Drop the new column
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('id_proof_document');
        });
    }
};
