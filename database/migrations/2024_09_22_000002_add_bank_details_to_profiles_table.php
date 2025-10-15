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
            if (!Schema::hasColumn('profiles', 'account_holder_name')) {
                $table->string('account_holder_name')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('profiles', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('account_holder_name');
            }
            if (!Schema::hasColumn('profiles', 'account_number')) {
                $table->string('account_number')->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('profiles', 'ifsc_code')) {
                $table->string('ifsc_code')->nullable()->after('account_number');
            }
            if (!Schema::hasColumn('profiles', 'account_type')) {
                $table->enum('account_type', ['savings', 'current'])->nullable()->after('ifsc_code');
            }
            if (!Schema::hasColumn('profiles', 'bank_branch')) {
                $table->string('bank_branch')->nullable()->after('account_type');
            }
            if (!Schema::hasColumn('profiles', 'bank_document')) {
                $table->string('bank_document')->nullable()->after('bank_branch');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'account_holder_name')) {
                $table->dropColumn('account_holder_name');
            }
            if (Schema::hasColumn('profiles', 'bank_name')) {
                $table->dropColumn('bank_name');
            }
            if (Schema::hasColumn('profiles', 'account_number')) {
                $table->dropColumn('account_number');
            }
            if (Schema::hasColumn('profiles', 'ifsc_code')) {
                $table->dropColumn('ifsc_code');
            }
            if (Schema::hasColumn('profiles', 'account_type')) {
                $table->dropColumn('account_type');
            }
            if (Schema::hasColumn('profiles', 'bank_branch')) {
                $table->dropColumn('bank_branch');
            }
            if (Schema::hasColumn('profiles', 'bank_document')) {
                $table->dropColumn('bank_document');
            }
        });
    }
};