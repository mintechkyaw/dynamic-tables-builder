<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quis-dolores-debitis-recusandae-et-et', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ab')->nullable();
            $table->enum('assumenda', ['temporibus', 'occaecati', 'ipsum'])->nullable();
            $table->string('atque')->notNullable();
            $table->date('aut')->notNullable();
            $table->json('dicta')->nullable();
            $table->date('eos')->notNullable();
            $table->string('illo')->nullable();
            $table->string('molestiae')->notNullable();
            $table->json('nihil')->notNullable();
            $table->json('quis')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quis-dolores-debitis-recusandae-et-et');
    }
};