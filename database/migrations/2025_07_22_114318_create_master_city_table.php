<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('master_city')) {
            Schema::create('master_city', function (Blueprint $table) {
                $table->id();
                $table->string('city_name');
                $table->integer('city_state_id');
                $table->string('state_code');
                $table->mediumInteger('country_id');
                $table->char('country_code', 2);
                $table->decimal('latitude', 10, 8);
                $table->decimal('longitude', 11, 8);
                $table->timestamp('created_at')->default(DB::raw("'2014-01-01 06:31:01'"));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->tinyInteger('flag')->default(1);
                $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');
                $table->integer('city_status')->default(1);

                $table->index('city_state_id', 'cities_test_ibfk_1');
                $table->index('country_id', 'cities_test_ibfk_2');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_city');
    }
};