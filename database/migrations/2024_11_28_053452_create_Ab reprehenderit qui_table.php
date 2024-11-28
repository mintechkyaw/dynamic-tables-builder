<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Ab reprehenderit qui', function (Blueprint $table) {
            $table->id();

            $table->string('name')->notNullable();
            $table->string('age')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Ab reprehenderit qui');
    }
};