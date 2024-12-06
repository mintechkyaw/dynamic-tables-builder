<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ea-omnis', function (Blueprint $table) {
            $table->id();
            $table->string('accusantium')->notNullable();
            $table->string('adipisci')->notNullable();
            $table->string('amet')->notNullable();
            $table->string('debitis')->nullable();
            $table->date('dolorem')->nullable();
            $table->date('et')->notNullable();
            $table->string('quae')->notNullable();
            $table->string('quo')->nullable();
            $table->enum('sit', ['sequi', 'ut', 'cum'])->nullable();
            $table->string('voluptatem')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ea-omnis');
    }
};