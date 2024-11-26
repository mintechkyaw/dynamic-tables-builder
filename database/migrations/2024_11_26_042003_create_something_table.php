<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('something', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('age')->notNullable();
            $table->enum('gender', ['male', 'female'])->notNullable();
            $table->string('name')->notNullable();
            $table->json('some')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('something');
    }
};
