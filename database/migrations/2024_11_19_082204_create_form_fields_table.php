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
            $table->id();
            $table->foreignId('form_id')->constrained()->cascadeOnDelete();
            $table->string('column_name');
            $table->enum('data_type', ['string', 'number', 'enum', 'date']);
            $table->enum('type', ['text', 'check_box', 'radio']);
            $table->json('options')->nullable();
            $table->boolean(column: 'required')->default(false);
            $table->timestamps();
            $table->unique(['form_id', 'column_name']);
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
