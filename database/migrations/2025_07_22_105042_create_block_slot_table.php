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
        if (!Schema::hasTable('block_slot')) {
            Schema::create('block_slot', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('event_id');
                $table->integer('quantity')->nullable();
                $table->integer('total_price');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_slot');
    }
};
