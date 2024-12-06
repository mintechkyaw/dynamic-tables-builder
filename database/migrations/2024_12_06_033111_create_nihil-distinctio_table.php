<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nihil-distinctio', function (Blueprint $table) {
            $table->id();
            $table->enum('ad', ['modi', 'ut', 'repellendus'])->nullable();
            $table->json('cum')->notNullable();
            $table->string('doloremque')->nullable();
            $table->json('iste')->nullable();
            $table->enum('neque', ['qui', 'blanditiis', 'non'])->notNullable();
            $table->enum('nesciunt', ['cumque', 'quasi', 'eum'])->notNullable();
            $table->string('nisi')->nullable();
            $table->json('occaecati')->notNullable();
            $table->date('qui')->nullable();
            $table->json('veritatis')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nihil-distinctio');
    }
};