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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('form_id');
            $table->string('column_name');
            $table->enum('data_type', ['string', 'integer', 'json', 'enum', 'date']);
            $table->enum('type', ['text', 'number', 'check_box', 'radio', 'calendar']);
            $table->json('options')->nullable();
            $table->boolean('required')->default(false);
            $table->timestamps();
            $table->unique(['form_id', 'column_name']);

            $table->foreign('form_id')->references('id')->on('forms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
