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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('image');               // Blog thumbnail image
            $table->string('category');            // Category name
            $table->date('published_at');          // Date of post
            $table->string('title');               // Blog post title
            $table->text('content');               // Blog summary or intro
            $table->string('author_name');         // Author name
            $table->string('author_avatar');       // Author avatar image
            $table->unsignedInteger('comment_count')->default(0); // Number of comments
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
