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
        
            for ($i = 1; $i <= 3; $i++) {
                $table->string("experience_heading{$i}")->nullable();
                $table->integer("experience_percentage{$i}")->nullable();
                $table->text("description{$i}")->nullable();
            }
        
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
