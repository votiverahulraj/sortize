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
        if (!Schema::hasTable('policy')) {
            Schema::create('policy', function (Blueprint $table) {
                $table->id();
                $table->string('policy_name', 128);
                $table->longText('policy_content');
                $table->tinyInteger('policy_type')->comment('1-privacy/2-terms/3-about/4-faq');
                $table->tinyInteger('is_deleted')->default(0)->comment('0-no/1-yes');
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
        Schema::dropIfExists('personal_policy');
    }
};