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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('specialization')->nullable();
            $table->string('experience')->nullable();
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->text('address')->nullable();
            $table->text('education')->nullable();
            $table->text('comments')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->json('gallery')->nullable(); 
            $table->string('qualification_document')->nullable();
            $table->string('aadhaar_card')->nullable();
            $table->string('pan_card')->nullable();
            $table->timestamps();
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
