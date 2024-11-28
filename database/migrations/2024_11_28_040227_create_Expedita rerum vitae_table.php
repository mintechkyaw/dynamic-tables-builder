<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Expedita rerum vitae', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('Diana Allen')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Expedita rerum vitae');
    }
};