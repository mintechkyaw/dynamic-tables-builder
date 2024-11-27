<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Non quia iure rerum', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Jameson Rush')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Non quia iure rerum');
    }
};