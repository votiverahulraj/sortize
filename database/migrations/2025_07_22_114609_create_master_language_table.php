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
        if (!Schema::hasTable('master_language')) {
            Schema::create('master_language', function (Blueprint $table) {
                $table->id();
                $table->string('language', 64);
                $table->tinyInteger('is_active')->default(1)->comment('0-no/1-yes');
                $table->tinyInteger('is_deleted')->default(0)->comment('0-no/1-yes');
                $table->dateTime('created_at');
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_language');
    }
};