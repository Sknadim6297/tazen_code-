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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('job_type')->nullable(); // Remote, Full-time, Part-time, etc.
            $table->string('department')->nullable(); // Operations, Engineering, etc.
            $table->text('description')->nullable();
            $table->text('who_are_we')->nullable();
            $table->text('expectation_of_role')->nullable();
            $table->text('accounts_payable_payroll')->nullable();
            $table->text('accounts_receivable')->nullable();
            $table->text('financial_reporting')->nullable();
            $table->text('requirements')->nullable();
            $table->text('what_we_offer')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
