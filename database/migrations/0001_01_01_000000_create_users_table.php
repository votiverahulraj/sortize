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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('first_name', 64);
                $table->string('last_name', 64);
                $table->string('display_name', 64)->nullable();
                $table->string('email', 64)->unique();
                $table->string('contact_number', 64)->nullable();
                $table->string('password', 64)->nullable();
                $table->string('c_name', 64)->nullable();
                $table->string('Website_link', 64)->nullable();
                $table->string('company_type', 64)->nullable();
                $table->string('profile_image', 32)->nullable();
                $table->tinyInteger('gender')->nullable()->comment('1-male/2-female/3-other');
                $table->text('short_bio')->nullable();
                $table->text('detailed_bio')->nullable();
                $table->mediumText('exp_and_achievement')->nullable();
                $table->string('professional_title', 128)->nullable();
                $table->string('company_name', 100)->nullable();
                $table->string('professional_profile', 255)->nullable();
                $table->unsignedInteger('country_id')->nullable();
                $table->unsignedInteger('state_id')->nullable();
                $table->string('city_id', 255)->nullable();
                $table->tinyInteger('user_type')->default(2)->comment('1-admin /2-user /3-coach');
                $table->tinyInteger('is_paid')->default(0)->comment('0-no/1-yes');
                $table->string('user_timezone', 64)->nullable();
                $table->tinyInteger('user_status')->default(0)->comment('0-pending/1-approved/2-suspended');
                $table->tinyInteger('is_deleted')->default(0)->comment('0-no/1-yes');
                $table->tinyInteger('email_verified')->default(1)->comment('0-no/1-yes');
                $table->tinyInteger('is_verified')->default(1)->comment('0-not verified / 1-verified badge');
                $table->tinyInteger('is_corporate')->default(1);
                $table->dateTime('verification_at')->nullable();
                $table->string('verification_token', 64)->nullable();
                $table->string('email_verification_token', 255)->nullable();
                $table->string('reset_token', 64)->nullable();
                $table->string('student_certificate', 255)->nullable();
                $table->dateTime('created_at');
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
