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
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id')->nullable();
                $table->string('event_name')->nullable();
                $table->tinyInteger('event_type')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->dateTime('date_time')->nullable();
                $table->string('address')->nullable();
                $table->string('google_address')->nullable();
                $table->string('lat')->nullable();
                $table->string('long')->nullable();
                $table->integer('price')->nullable();
                $table->string('event_days')->nullable();
                $table->integer('ticket_quantity')->nullable();
                $table->integer('ticket_price')->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->string('duration')->nullable();
                $table->integer('gap')->nullable();
                $table->tinyInteger('event_limit')->nullable();
                $table->string('media')->nullable();
                $table->string('description')->nullable();
                $table->tinyInteger('is_deleted');
                $table->tinyInteger('status')->nullable();
                $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};