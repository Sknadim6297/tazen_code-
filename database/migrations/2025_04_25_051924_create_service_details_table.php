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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            
            // Banner Section
            $table->string('banner_image')->nullable();
            $table->string('banner_heading');
            $table->string('banner_sub_heading')->nullable();
            
            // About Section
            $table->string('about_heading');
            $table->string('about_subheading')->nullable();
            $table->text('about_description');
            $table->string('about_image')->nullable();
            
            // How It Works Section
            $table->string('how_it_works_subheading')->nullable();
            $table->string('content_heading');
            $table->string('content_sub_heading')->nullable();
            $table->string('background_image')->nullable();
            
            // Steps
            $table->string('step1_heading');
            $table->text('step1_description');
            $table->string('step2_heading')->nullable();
            $table->text('step2_description')->nullable();
            $table->string('step3_heading')->nullable();
            $table->text('step3_description')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
