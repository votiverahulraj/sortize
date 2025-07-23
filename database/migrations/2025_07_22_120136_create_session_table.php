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
        if (!Schema::hasTable('session')) {
            Schema::create('session', function (Blueprint $table) {
                $table->id();
                $table->integer('event_id')->nullable();
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time');
                $table->string('capacity')->nullable();
                $table->tinyInteger('is_active')->nullable();
                $table->string('status')->default('active');
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
        Schema::dropIfExists('session');
    }
};