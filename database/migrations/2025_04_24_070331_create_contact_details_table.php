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
        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();

            // First Contact Detail
            $table->string('icon1')->nullable();
            $table->string('heading1')->nullable();
            $table->string('sub_heading1')->nullable();
            $table->text('description1')->nullable();

            // Second Contact Detail
            $table->string('icon2')->nullable();
            $table->string('heading2')->nullable();
            $table->string('sub_heading2')->nullable();
            $table->text('description2')->nullable();

            // Third Contact Detail
            $table->string('icon3')->nullable();
            $table->string('heading3')->nullable();
            $table->string('sub_heading3')->nullable();
            $table->text('description3')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_details');
    }
};
