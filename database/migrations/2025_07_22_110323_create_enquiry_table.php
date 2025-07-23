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
        if (!Schema::hasTable('enquiry')) {
            Schema::create('enquiry', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('coach_id');
                $table->text('enquiry_title');
                $table->text('enquiry_detail');
                $table->tinyInteger('is_seen')->comment('0-no/1-yes');
                $table->tinyInteger('enquiry_status')->default(0)->comment('0-pending/in-progress/3-closed');
                $table->tinyInteger('is_deleted')->comment('0-no/1-yes');
                $table->dateTime('created_at');
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry');
    }
};