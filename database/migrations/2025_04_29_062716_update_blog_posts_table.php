<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Add the blog_id column
            $table->unsignedBigInteger('blog_id')->nullable()->after('id');

            // Set foreign key constraint
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');

            // Remove the title column
            $table->dropColumn('title');
        });
    }

    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Remove the blog_id column
            $table->dropForeign(['blog_id']);
            $table->dropColumn('blog_id');

            // Add the title column back
            $table->string('title');
        });
    }
}
