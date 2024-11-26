<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('astsda')->notNullable();
            $table->string('sdfgert')->notNullable();
            $table->string('waeear')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};