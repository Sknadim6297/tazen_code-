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
        Schema::table('job_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('job_applications', 'career_id')) {
                $table->foreignId('career_id')->nullable()->constrained('careers')->onDelete('cascade')->after('id');
            }
            if (!Schema::hasColumn('job_applications', 'full_name')) {
                $table->string('full_name')->nullable()->after('career_id');
            }
            if (!Schema::hasColumn('job_applications', 'email')) {
                $table->string('email')->nullable()->after('full_name');
            }
            if (!Schema::hasColumn('job_applications', 'phone_country')) {
                $table->string('phone_country')->nullable()->after('email');
            }
            if (!Schema::hasColumn('job_applications', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('phone_country');
            }
            if (!Schema::hasColumn('job_applications', 'compensation_expectation')) {
                $table->string('compensation_expectation')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('job_applications', 'why_perfect_fit')) {
                $table->text('why_perfect_fit')->nullable()->after('compensation_expectation');
            }
            if (!Schema::hasColumn('job_applications', 'cv_resume')) {
                $table->string('cv_resume')->nullable()->after('why_perfect_fit');
            }
            if (!Schema::hasColumn('job_applications', 'cover_letter_file')) {
                $table->string('cover_letter_file')->nullable()->after('cv_resume');
            }
            if (!Schema::hasColumn('job_applications', 'cover_letter_text')) {
                $table->text('cover_letter_text')->nullable()->after('cover_letter_file');
            }
            if (!Schema::hasColumn('job_applications', 'status')) {
                $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending')->after('cover_letter_text');
            }
            if (!Schema::hasColumn('job_applications', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (Schema::hasColumn('job_applications', 'career_id')) {
                $table->dropForeign(['career_id']);
                $table->dropColumn('career_id');
            }
            $columns = [
                'full_name',
                'email',
                'phone_country',
                'phone_number',
                'compensation_expectation',
                'why_perfect_fit',
                'cv_resume',
                'cover_letter_file',
                'cover_letter_text',
                'status',
                'admin_notes',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('job_applications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
