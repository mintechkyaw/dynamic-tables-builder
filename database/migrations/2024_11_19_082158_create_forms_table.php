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
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->enum('status', ['drafted', 'published'])->default('drafted');
            $table->timestamps();
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('form_id')->constrained('forms')->cascadeOnDelete();
            $table->string('column_name');
            $table->enum('data_type', ['string', 'integer', 'json', 'enum', 'date']);
            $table->enum('type', ['text', 'number', 'check_box', 'radio', 'calendar']);
            $table->json('options')->nullable();
            $table->boolean('required')->default(false);
            $table->timestamps();

            $table->unique(['form_id', 'column_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
        Schema::dropIfExists('form_fields');
    }
};
