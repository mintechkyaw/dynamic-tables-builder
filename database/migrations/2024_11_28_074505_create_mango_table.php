<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mango', function (Blueprint $table) {
            $table->id();

            $table->string('fruit_name')->notNullable();
            $table->string('age')->notNullable();
            $table->enum('genter', ['male', 'fesmale'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mango');
    }
};