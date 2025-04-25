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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('section_sub_heading')->nullable();

            // Testimonial 1
            $table->string('image1')->nullable();
            $table->text('description1')->nullable();

            // Testimonial 2
            $table->string('image2')->nullable();
            $table->text('description2')->nullable();

            // Testimonial 3
            $table->string('image3')->nullable();
            $table->text('description3')->nullable();

            // Testimonial 4
            $table->string('image4')->nullable();
            $table->text('description4')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
