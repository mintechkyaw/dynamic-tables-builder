<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('somethingtwo', function (Blueprint $table) {
            $table->id();

            $table->json('some_caheck')->notNullable();
            $table->string('some_naem')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('somethingtwo');
    }
};