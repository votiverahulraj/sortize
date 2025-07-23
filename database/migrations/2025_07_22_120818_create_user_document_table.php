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
        if (!Schema::hasTable('user_document')) {
            Schema::create('user_document', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->string('document_file', 128);
                $table->string('original_name', 128);
                $table->tinyInteger('document_type')
                    ->comment('1 - Certificate, 2 - CV, 3 - Brochure');
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
        Schema::dropIfExists('user_document');
    }
};