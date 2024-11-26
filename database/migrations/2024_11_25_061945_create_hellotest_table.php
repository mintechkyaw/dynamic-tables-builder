<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hellotest', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('aseesdf', ['sdafas', 'asdf', 'sdf'])->notNullable();
            $table->json('ggggg')->notNullable();
            $table->string('hhhhhhh')->notNullable();
            $table->string('rererer')->notNullable();
            $table->string('tetete')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hellotest');
    }
};
