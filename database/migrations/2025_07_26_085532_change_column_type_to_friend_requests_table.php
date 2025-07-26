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
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->boolean('is_blocked')->default(0)->comment(null)->change();
            $table->tinyInteger('status')->default(1)->comment("1=sent,2=accept,3=declined")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('friend_requests', function (Blueprint $table) {
            //
        });
    }
};