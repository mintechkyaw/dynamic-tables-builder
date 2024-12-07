<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nemo quam molestiae', function (Blueprint $table) {
            $table->id();
            $table->json('enim')->nullable();
            $table->string('eum')->nullable();
            $table->enum('exercitationem', ['quia', 'sit', 'illum'])->notNullable();
            $table->enum('illum', ['eos', 'ratione', 'aliquid'])->nullable();
            $table->enum('libero', ['deserunt', 'voluptas', 'quia'])->nullable();
            $table->json('modi')->notNullable();
            $table->string('necessitatibus')->nullable();
            $table->date('placeat')->notNullable();
            $table->enum('reiciendis', ['dolorem', 'incidunt', 'eum'])->nullable();
            $table->string('ullam')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nemo quam molestiae');
    }
};