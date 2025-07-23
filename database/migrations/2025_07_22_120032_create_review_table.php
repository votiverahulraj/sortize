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
        if (!Schema::hasTable('review')) {
            Schema::create('review', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->integer('coach_id');
                $table->integer('event_id');
                $table->text('review_text')->nullable();
                $table->decimal('rating', 10, 2)->nullable();
                $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('review');
    }
};