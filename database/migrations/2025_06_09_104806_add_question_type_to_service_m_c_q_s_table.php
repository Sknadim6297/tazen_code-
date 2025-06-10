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
        Schema::table('service_m_c_q_s', function (Blueprint $table) {
            // Add new columns
            $table->string('question_type')->default('mcq')->after('question');
            $table->json('options')->nullable()->after('answer4');
            $table->boolean('has_other_option')->default(false)->after('options');
        });

        // Migrate existing data
        DB::table('service_m_c_q_s')->update([
            'question_type' => 'mcq',
            'options' => DB::raw("JSON_ARRAY(answer1, answer2, answer3, answer4)"),
            'has_other_option' => false
        ]);

        // Drop old columns after data migration
        Schema::table('service_m_c_q_s', function (Blueprint $table) {
            $table->dropColumn(['answer1', 'answer2', 'answer3', 'answer4']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_m_c_q_s', function (Blueprint $table) {
            // Add back the old columns
            $table->string('answer1')->after('question');
            $table->string('answer2')->after('answer1');
            $table->string('answer3')->after('answer2');
            $table->string('answer4')->after('answer3');
        });

        // Migrate data back
        DB::table('service_m_c_q_s')->each(function ($row) {
            $options = json_decode($row->options, true);
            DB::table('service_m_c_q_s')
                ->where('id', $row->id)
                ->update([
                    'answer1' => $options[0] ?? '',
                    'answer2' => $options[1] ?? '',
                    'answer3' => $options[2] ?? '',
                    'answer4' => $options[3] ?? '',
                ]);
        });

        // Drop new columns
        Schema::table('service_m_c_q_s', function (Blueprint $table) {
            $table->dropColumn(['question_type', 'options', 'has_other_option']);
        });
    }
};
