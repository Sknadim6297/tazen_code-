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
        Schema::create('howworks', function (Blueprint $table) {
            $table->id();
        $table->string('section_sub_heading')->nullable();

        // First block
        $table->string('image1')->nullable();
        $table->string('heading1')->nullable();
        $table->text('description1')->nullable();

        // Second block
        $table->string('image2')->nullable();
        $table->string('heading2')->nullable();
        $table->text('description2')->nullable();

        // Third block
        $table->string('image3')->nullable();
        $table->string('heading3')->nullable();
        $table->text('description3')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('howworks');
    }
};
