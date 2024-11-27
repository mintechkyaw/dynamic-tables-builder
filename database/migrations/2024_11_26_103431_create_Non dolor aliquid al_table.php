<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Non dolor aliquid al', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Desirae Perkins')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Non dolor aliquid al');
    }
};