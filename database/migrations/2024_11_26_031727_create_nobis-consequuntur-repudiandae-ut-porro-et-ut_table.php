<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nobis-consequuntur-repudiandae-ut-porro-et-ut', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('consequatur')->nullable();
            $table->string('dolorum')->notNullable();
            $table->string('inventore')->notNullable();
            $table->date('placeat')->nullable();
            $table->string('quam')->notNullable();
            $table->json('quos')->nullable();
            $table->string('repellendus')->nullable();
            $table->enum('temporibus', ['quidem', 'illo', 'nulla'])->notNullable();
            $table->string('vel')->notNullable();
            $table->json('veritatis')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nobis-consequuntur-repudiandae-ut-porro-et-ut');
    }
};