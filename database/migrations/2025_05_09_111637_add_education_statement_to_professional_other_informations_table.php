<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEducationStatementToProfessionalOtherInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professional_other_informations', function (Blueprint $table) {
            $table->text('education_statement')->nullable()->after('education');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professional_other_informations', function (Blueprint $table) {
            $table->dropColumn('education_statement');
        });
    }
}
