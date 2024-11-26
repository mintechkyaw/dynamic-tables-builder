<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('njjioklk', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->notNullable();
            $table->json('terertsadf')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('njjioklk');
    }
};