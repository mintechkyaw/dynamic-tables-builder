<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Accusamus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('Melanie Buckley')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Accusamus');
    }
};