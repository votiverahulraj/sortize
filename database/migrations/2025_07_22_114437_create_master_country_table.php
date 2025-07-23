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
        if (!Schema::hasTable('master_country')) {
            Schema::create('master_country', function (Blueprint $table) {
                $table->integer('country_id')->primary();
                $table->string('country_name', 150);
                $table->char('iso3', 3)->nullable();
                $table->char('numeric_code', 3)->nullable();
                $table->char('iso2', 2)->nullable();
                $table->string('phonecode')->nullable();
                $table->string('capital')->nullable();
                $table->string('currency')->nullable();
                $table->string('currency_name')->nullable();
                $table->string('currency_symbol')->nullable();
                $table->string('tld')->nullable();
                $table->string('native')->nullable();
                $table->string('region')->nullable();
                $table->string('subregion')->nullable();
                $table->text('timezones')->nullable();
                $table->text('translations')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->string('emoji', 191)->nullable();
                $table->string('emojiU', 191)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->tinyInteger('flag')->default(1);
                $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');
                $table->integer('country_status')->comment('0-no/1-yes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_country');
    }
};