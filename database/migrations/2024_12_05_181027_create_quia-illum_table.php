<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quia-illum', function (Blueprint $table) {
            $table->id();
            $table->string('blanditiis')->notNullable();
            $table->date('facere')->nullable();
            $table->string('itaque')->nullable();
            $table->date('laudantium')->nullable();
            $table->json('minima')->nullable();
            $table->string('officia')->nullable();
            $table->date('rerum')->nullable();
            $table->string('sunt')->nullable();
            $table->json('vel')->notNullable();
            $table->enum('voluptates', ['sapiente', 'minus', 'quo'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quia-illum');
    }
};