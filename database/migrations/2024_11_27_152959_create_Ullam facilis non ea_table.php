<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Ullam facilis non ea', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Camilla Soto')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Ullam facilis non ea');
    }
};