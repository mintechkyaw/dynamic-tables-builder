<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNullable();
            $table->string('age')->notNullable();
            $table->enum('gender', ['male', 'female'])->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test');
    }
};