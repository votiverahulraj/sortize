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
        if (!Schema::hasTable('master_state')) {
            Schema::create('master_state', function (Blueprint $table) {
                $table->integer('state_id')->primary();
                $table->string('state_name', 150);
                $table->integer('state_country_id');
                $table->char('country_code', 2);
                $table->string('fips_code')->nullable();
                $table->string('iso2')->nullable();
                $table->string('type', 191)->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->tinyInteger('flag')->default(1);
                $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');

                $table->index('state_country_id', 'country_region');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_state');
    }
};