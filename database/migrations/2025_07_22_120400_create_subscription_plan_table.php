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
        if (!Schema::hasTable('subscription_plan')) {
            Schema::create('subscription_plan', function (Blueprint $table) {
                $table->id();
                $table->string('plan_name', 64);
                $table->text('plan_content');
                $table->decimal('plan_amount', 10, 2);
                $table->string('plan_duration', 64)->comment('max 3 digit');
                $table->string('duration_unit', 64)->comment('1-Day , 2-Month, 3-Year');
                $table->tinyInteger('is_active')->default(1)->comment('0-no/1-yes');
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
        Schema::dropIfExists('subscription_plan');
    }
};