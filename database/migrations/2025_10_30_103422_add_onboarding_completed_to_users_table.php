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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('customer_onboarding_completed_at')->nullable();
            $table->timestamp('professional_onboarding_completed_at')->nullable();
            $table->json('onboarding_data')->nullable(); // Store tour progress/preferences
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['customer_onboarding_completed_at', 'professional_onboarding_completed_at', 'onboarding_data']);
        });
    }
};
