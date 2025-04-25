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
        Schema::create('about_experiences', function (Blueprint $table) {
        $table->id();
        $table->string('section_heading')->nullable();
        $table->string('section_subheading')->nullable();
        $table->string('content_heading')->nullable();
        $table->string('content_subheading')->nullable();

        $table->string('experience_heading1')->nullable();
        $table->integer('experience_percentage1')->nullable();
        $table->text('description1')->nullable();

        $table->string('experience_heading2')->nullable();
        $table->integer('experience_percentage2')->nullable();
        $table->text('description2')->nullable();

        $table->string('experience_heading3')->nullable();
        $table->integer('experience_percentage3')->nullable();
        $table->text('description3')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_experiences');
    }
};
