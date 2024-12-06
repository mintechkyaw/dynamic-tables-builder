<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('distinctio porro ab', function (Blueprint $table) {
            $table->id();
            $table->json('aut')->notNullable();
            $table->date('dicta')->nullable();
            $table->json('dolores')->notNullable();
            $table->enum('eos', ['inventore', 'magni', 'similique'])->notNullable();
            $table->json('et')->nullable();
            $table->enum('ex', ['dolorum', 'quia', 'numquam'])->nullable();
            $table->string('necessitatibus')->nullable();
            $table->json('officiis')->nullable();
            $table->string('qui')->nullable();
            $table->enum('repudiandae', ['et', 'qui', 'laborum'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distinctio porro ab');
    }
};