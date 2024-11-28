<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();

            $table->string('product_name')->notNullable();
            $table->string('p_age')->notNullable();
            $table->enum('gender', ['male', 'female', 'gay', 'lesbian'])->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product');
    }
};