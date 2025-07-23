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
        if (!Schema::hasTable('user_subscription')) {
            Schema::create('user_subscription', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('plan_id');
                $table->decimal('amount', 10, 2);
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->string('txn_id', 64);
                $table->tinyInteger('is_active')->comment('0-no / 1-yes');
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
        Schema::dropIfExists('user_subscription');
    }
};