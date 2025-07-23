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
        if (!Schema::hasTable('age_group')) {
        Schema::create('age_group', function (Blueprint $table) {
            $table->id();
            $table->string('group_name', 64)->nullable();
            $table->string('age_range', 64)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('age_group');
    }
};
