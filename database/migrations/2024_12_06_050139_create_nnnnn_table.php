<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nnnnn', function (Blueprint $table) {
            $table->id();
            $table->json('fffff')->nullable();
            $table->string('lll')->notNullable();
            $table->string('mmm')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nnnnn');
    }
};