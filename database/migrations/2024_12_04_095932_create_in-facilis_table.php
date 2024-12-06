<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('in-facilis', function (Blueprint $table) {
            $table->id();
            $table->date('dolore')->notNullable();
            $table->string('dolores')->notNullable();
            $table->json('esse')->nullable();
            $table->string('excepturi')->nullable();
            $table->string('mollitia')->nullable();
            $table->string('nihil')->notNullable();
            $table->enum('officiis', ['iure', 'maiores', 'explicabo'])->notNullable();
            $table->enum('repellat', ['consectetur', 'labore', 'et'])->notNullable();
            $table->string('ullam')->notNullable();
            $table->date('voluptas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('in-facilis');
    }
};