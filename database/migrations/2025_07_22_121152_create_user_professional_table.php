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
        if (!Schema::hasTable('user_professional')) {
            Schema::create('user_professional', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->text('video_link')->nullable();
                $table->integer('coach_type')->nullable();
                $table->integer('age_group')->nullable();
                $table->integer('coach_subtype')->nullable();
                $table->string('experience', 64)->nullable();
                $table->integer('coaching_category')->nullable();
                $table->integer('delivery_mode')->nullable();
                $table->tinyInteger('free_trial_session')->nullable();
                $table->integer('price')->nullable();
                $table->tinyInteger('is_volunteered_coach')->nullable();
                $table->text('volunteer_coaching')->nullable();
                $table->string('website_link', 128)->nullable();
                $table->string('insta_link', 255);
                $table->string('fb_link', 255);
                $table->string('linkdin_link', 255);
                $table->string('booking_link', 255);
                $table->text('objective')->nullable();
                $table->dateTime('created_at');
                $table->timestamp('updated_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_professional');
    }
};