<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('marketing', function (Blueprint $table) {
            $table->id();

            $table->string('phone')->notNullable();
            $table->string('email')->notNullable();
            $table->string('name')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketing');
    }
};