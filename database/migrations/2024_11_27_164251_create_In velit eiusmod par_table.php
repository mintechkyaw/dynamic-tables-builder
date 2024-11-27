<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('In velit eiusmod par', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('Nora Hubbard')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('In velit eiusmod par');
    }
};