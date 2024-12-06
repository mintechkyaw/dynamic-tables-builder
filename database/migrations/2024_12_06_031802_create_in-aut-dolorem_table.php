<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('in-aut-dolorem', function (Blueprint $table) {
            $table->id();
            $table->json('animi')->nullable();
            $table->string('aperiam')->nullable();
            $table->string('blanditiis')->nullable();
            $table->string('delectus')->nullable();
            $table->string('ea')->notNullable();
            $table->enum('error', ['et', 'autem', 'vitae'])->notNullable();
            $table->string('labore')->notNullable();
            $table->json('modi')->notNullable();
            $table->string('nulla')->nullable();
            $table->string('rem')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('in-aut-dolorem');
    }
};