<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('test1', function (Blueprint $table) {
            $table->id();

            $table->string('Byron Day')->notNullable();
            $table->string('Maxine Hale')->notNullable();
            $table->json('Omar Moore')->notNullable();
            $table->enum('Donovan Stevenson', ['Repudiandae qui pari', 'Aut dolorem dolor la', 'Nulla et optio magn', 'Tempore quis at des'])->nullable();
            $table->string('Hakeem Mercado')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test1');
    }
};