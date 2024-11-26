<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('adipisci-molestias-nostrum-dolore-quaerat-sed-ipsam', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('aliquid')->nullable();
            $table->string('deleniti')->nullable();
            $table->string('fugit')->notNullable();
            $table->string('harum')->nullable();
            $table->string('illo')->notNullable();
            $table->string('incidunt')->notNullable();
            $table->json('magni')->notNullable();
            $table->date('minima')->notNullable();
            $table->string('ratione')->notNullable();
            $table->string('reprehenderit')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adipisci-molestias-nostrum-dolore-quaerat-sed-ipsam');
    }
};