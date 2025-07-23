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
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedInteger('event_id')->nullable();
                $table->unsignedInteger('event_slot_id')->nullable();
                $table->integer('ticket_quantity')->nullable();
                $table->decimal('total_price', 10, 2)->nullable();
                $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
                $table->enum('booking_status', ['active', 'cancelled', 'completed'])->default('active');
                $table->dateTime('booked_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->tinyInteger('is_active')->default(1);
                $table->dateTime('cancelled_at')->nullable();
                $table->timestamps();

                $table->index('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};