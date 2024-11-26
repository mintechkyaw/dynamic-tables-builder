<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('egonetest', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('testcolumn')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('egonetest');
    }
};