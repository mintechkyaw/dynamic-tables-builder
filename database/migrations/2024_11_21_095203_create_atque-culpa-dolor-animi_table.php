<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('atque-culpa-dolor-animi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('aperiam')->nullable();
            $table->integer('dolore')->nullable();
            $table->string('earum')->nullable();
            $table->string('et')->nullable();
            $table->integer('fugiat')->nullable();
            $table->date('illum')->nullable();
            $table->date('non')->nullable();
            $table->string('nulla')->nullable();
            $table->date('praesentium')->nullable();
            $table->date('velasdfsa')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atque-culpa-dolor-animi');
    }
};