<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('consequatur-ex-earum-quia-sit-vero', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('eos')->nullable();
            $table->date('exercitationem')->nullable();
            $table->string('in')->nullable();
            $table->integer('occaecati')->nullable();
            $table->date('pariatur')->nullable();
            $table->string('reiciendis')->nullable();
            $table->string('repellendus')->nullable();
            $table->string('sit')->nullable();
            $table->date('unde')->nullable();
            $table->string('vitae')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consequatur-ex-earum-quia-sit-vero');
    }
};