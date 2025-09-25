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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('account_holder_name')->nullable()->after('bio');
            $table->string('bank_name')->nullable()->after('account_holder_name');
            $table->string('account_number')->nullable()->after('bank_name');
            $table->string('ifsc_code')->nullable()->after('account_number');
            $table->enum('account_type', ['savings', 'current'])->nullable()->after('ifsc_code');
            $table->string('bank_branch')->nullable()->after('account_type');
            $table->string('bank_document')->nullable()->after('bank_branch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'account_holder_name',
                'bank_name',
                'account_number',
                'ifsc_code',
                'account_type',
                'bank_branch',
                'bank_document'
            ]);
        });
    }
};