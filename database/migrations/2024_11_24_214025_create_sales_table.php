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
            $table->string('age')->notNullable();
            $table->string('asdf')->notNullable();
            $table->string('name')->notNullable();
            $table->enum('rewrwe', ['asdf', 'asdf', 'asf'])->notNullable();
            $table->json('tttt')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};