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
        Schema::create('admin_professional_chat_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id');
            $table->string('original_name');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type'); // image, document, video, etc.
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size'); // in bytes
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('message_id')->references('id')->on('admin_professional_chat_messages')->onDelete('cascade');

            // Indexes for better performance
            $table->index('message_id');
            $table->index('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_professional_chat_attachments');
    }
};
