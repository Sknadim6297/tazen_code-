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
        Schema::create('blog_banners', function (Blueprint $table) {
            $table->id();
            $table->string('heading');           // Blog banner heading
            $table->string('subheading');        // Blog banner subheading
            $table->string('banner_image');      // Banner image path
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_banners');
    }
};
