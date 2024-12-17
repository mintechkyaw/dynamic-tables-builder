<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('aut ipsam amet', function (Blueprint $table) {
            $table->id();
            $table->json('autem')->nullable();
            $table->string('deleniti')->notNullable();
            $table->string('exercitationem')->nullable();
            $table->date('id')->nullable();
            $table->json('nam')->notNullable();
            $table->string('numquam')->nullable();
            $table->enum('perferendis', ['tenetur', 'id', 'repudiandae'])->notNullable();
            $table->json('sed')->nullable();
            $table->string('sint')->notNullable();
            $table->string('veritatis')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aut ipsam amet');
    }
};