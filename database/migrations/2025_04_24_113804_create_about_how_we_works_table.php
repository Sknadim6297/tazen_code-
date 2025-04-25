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
        Schema::create('about_how_we_works', function (Blueprint $table) {
            $table->id();
            $table->string('section_heading')->nullable();
            $table->string('section_sub_heading')->nullable();
            $table->string('content_heading')->nullable();
            $table->string('content_sub_heading')->nullable();

            $table->string('step1_heading')->nullable();
            $table->text('step1_description')->nullable();

            $table->string('step2_heading')->nullable();
            $table->text('step2_description')->nullable();

            $table->string('step3_heading')->nullable();
            $table->text('step3_description')->nullable();

            $table->string('step4_heading')->nullable();
            $table->text('step4_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_how_we_works');
    }
};
