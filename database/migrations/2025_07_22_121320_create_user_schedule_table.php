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
        if (!Schema::hasTable('user_schedule')) {
            Schema::create('user_schedule', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->date('schedule_date');
                $table->time('start_time');
                $table->time('end_time');
                $table->tinyInteger('schedule_status')->comment('0-empty/1-booked');
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
        Schema::dropIfExists('user_schedule');
    }
};