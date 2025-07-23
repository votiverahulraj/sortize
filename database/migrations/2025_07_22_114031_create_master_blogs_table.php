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
        if (!Schema::hasTable('master_blogs')) {
            Schema::create('master_blogs', function (Blueprint $table) {
                $table->id();
                $table->string('blog_name', 64);
                $table->longText('blog_content');
                $table->string('blog_image', 255)->default('');
                $table->string('blog_video', 255)->default('');
                $table->tinyInteger('video_type')->comment('1-url/2-file');
                $table->tinyInteger('is_active')->comment('0-Inactive/1-Active');
                $table->tinyInteger('is_deleted')->default(0)->comment('0-no/1-yes');
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
        Schema::dropIfExists('master_blogs');
    }
};