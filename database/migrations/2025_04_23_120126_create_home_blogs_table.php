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
        Schema::create('home_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('section_sub_heading')->nullable();

            // Blog 1
            $table->string('image1')->nullable();
            $table->string('heading1')->nullable();
            $table->text('description1')->nullable();
            $table->string('by_whom1')->nullable();

            // Blog 2
            $table->string('image2')->nullable();
            $table->string('heading2')->nullable();
            $table->text('description2')->nullable();
            $table->string('by_whom2')->nullable();

            // Blog 3
            $table->string('image3')->nullable();
            $table->string('heading3')->nullable();
            $table->text('description3')->nullable();
            $table->string('by_whom3')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_blogs');
    }
};
