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
        if (!Schema::hasTable('friend_requests')) {
            Schema::create('friend_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('from_user_id');
                $table->unsignedInteger('to_user_id');
                $table->unsignedInteger('status')->nullable()->comment('1-send/2-accept/3-decline');
                $table->unsignedInteger('is_blocked')->nullable()->comment('1-blocked /2-Unblocked');
                $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_requests');
    }
};