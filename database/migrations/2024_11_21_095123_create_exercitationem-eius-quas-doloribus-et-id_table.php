<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exercitationem-eius-quas-doloribus-et-id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('autem')->nullable();
            $table->integer('consequatur')->nullable();
            $table->string('corrupti')->nullable();
            $table->date('incidunt')->nullable();
            $table->string('libero')->nullable();
            $table->string('mollitia')->nullable();
            $table->integer('natus')->nullable();
            $table->string('reprehenderit')->nullable();
            $table->string('sunt')->nullable();
            $table->integer('ut')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercitationem-eius-quas-doloribus-et-id');
    }
};