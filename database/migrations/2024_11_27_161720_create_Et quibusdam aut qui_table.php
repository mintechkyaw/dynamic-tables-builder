<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Et quibusdam aut qui', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('Christen Parker', ['Excepturi error aut', 'Odit eum saepe recus', 'Explicabo Cupidatat', 'Minima consequatur', 'Earum et sed explica', 'Aut velit dolorem q'])->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Et quibusdam aut qui');
    }
};