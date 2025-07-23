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
        if (!Schema::hasTable('user_service_packages')) {
            Schema::create('user_service_packages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('coach_id');
                $table->string('title');
                $table->tinyInteger('package_status')->default(1)->comment("0-unpublished, 1-published, 2-draft");
                $table->string('short_description', 200)->nullable();
                $table->string('coaching_category')->nullable();
                $table->text('description')->nullable();
                $table->string('focus')->nullable();
                $table->integer('coaching_type')->nullable();
                $table->string('delivery_mode', 100)->nullable();
                $table->integer('session_count')->nullable();
                $table->string('session_duration', 50)->nullable();
                $table->tinyInteger('session_format')->nullable();
                $table->string('age_group')->nullable();
                $table->string('price', 64)->nullable();
                $table->tinyInteger('price_model')->nullable();
                $table->string('currency', 3)->nullable();
                $table->string('booking_slots', 10)->nullable();
                $table->string('booking_availability', 64)->nullable();
                $table->string('booking_window', 100)->nullable();
                $table->string('cancellation_policy', 100)->nullable();
                $table->string('rescheduling_policy', 255)->nullable();
                $table->string('media_file')->nullable();
                $table->enum('status', ['draft', 'published'])->default('draft');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_service_packages');
    }
};