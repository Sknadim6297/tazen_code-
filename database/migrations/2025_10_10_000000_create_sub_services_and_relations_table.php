<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration is written defensively so it can be added to repositories
     * that may already have older sub-service migrations. It will only create
     * tables/columns if they don't already exist.
     *
     * @return void
     */
    public function up()
    {
        // Create sub_services table (final desired schema)
        if (! Schema::hasTable('sub_services')) {
            Schema::create('sub_services', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_id');
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                // price intentionally omitted per final design; kept nullable if added later
                $table->tinyInteger('status')->default(1)->comment('1=active,0=inactive');
                $table->timestamps();

                $table->foreign('service_id')
                      ->references('id')->on('services')
                      ->onDelete('cascade');
            });
        } else {
            // Ensure unwanted/legacy column `price` is dropped if present
            if (Schema::hasColumn('sub_services', 'price')) {
                Schema::table('sub_services', function (Blueprint $table) {
                    if (Schema::hasColumn('sub_services', 'price')) {
                        $table->dropColumn('price');
                    }
                });
            }
        }

        // Create pivot table for professional_service <-> sub_service
        if (! Schema::hasTable('prof_service_sub_services')) {
            Schema::create('prof_service_sub_services', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('professional_service_id');
                $table->unsignedBigInteger('sub_service_id');
                $table->timestamps();

                $table->foreign('professional_service_id')
                      ->references('id')->on('professional_services')
                      ->onDelete('cascade');

                $table->foreign('sub_service_id')
                      ->references('id')->on('sub_services')
                      ->onDelete('cascade');

                $table->unique(['professional_service_id', 'sub_service_id'], 'prof_service_sub_unique');
            });
        }

        // Add sub_service_id to rates
        if (Schema::hasTable('rates') && ! Schema::hasColumn('rates', 'sub_service_id')) {
            Schema::table('rates', function (Blueprint $table) {
                $table->unsignedBigInteger('sub_service_id')->nullable()->after('service_id');

                $table->foreign('sub_service_id')
                      ->references('id')->on('sub_services')
                      ->onDelete('set null');
            });
        }

        // Add sub_service_id to availabilities
        if (Schema::hasTable('availabilities') && ! Schema::hasColumn('availabilities', 'sub_service_id')) {
            Schema::table('availabilities', function (Blueprint $table) {
                $table->unsignedBigInteger('sub_service_id')->nullable()->after('service_id');

                $table->foreign('sub_service_id')
                      ->references('id')->on('sub_services')
                      ->onDelete('set null');
            });
        }

        // Add sub_service_id to bookings
        if (Schema::hasTable('bookings') && ! Schema::hasColumn('bookings', 'sub_service_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->unsignedBigInteger('sub_service_id')->nullable()->after('service_id');

                $table->foreign('sub_service_id')
                      ->references('id')->on('sub_services')
                      ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove sub_service_id from bookings
        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'sub_service_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropForeign(['sub_service_id']);
                $table->dropColumn('sub_service_id');
            });
        }

        // Remove sub_service_id from availabilities
        if (Schema::hasTable('availabilities') && Schema::hasColumn('availabilities', 'sub_service_id')) {
            Schema::table('availabilities', function (Blueprint $table) {
                $table->dropForeign(['sub_service_id']);
                $table->dropColumn('sub_service_id');
            });
        }

        // Remove sub_service_id from rates
        if (Schema::hasTable('rates') && Schema::hasColumn('rates', 'sub_service_id')) {
            Schema::table('rates', function (Blueprint $table) {
                $table->dropForeign(['sub_service_id']);
                $table->dropColumn('sub_service_id');
            });
        }

        // Drop pivot table
        if (Schema::hasTable('prof_service_sub_services')) {
            Schema::dropIfExists('prof_service_sub_services');
        }

        // Drop sub_services table
        if (Schema::hasTable('sub_services')) {
            Schema::dropIfExists('sub_services');
        }
    }
};
